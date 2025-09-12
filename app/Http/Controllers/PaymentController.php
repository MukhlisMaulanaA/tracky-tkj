<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // Hitung total pembayaran
    $totalPayments = Payment::sum('amount');

    // Pembayaran untuk invoice yang sudah lunas (DONE PAYMENT)
    $completedPayments = Payment::whereHas('invoice', function ($q) {
      $q->where('remarks', 'DONE PAYMENT');
    })->sum('amount');

    $pendingPayments = $totalPayments - $completedPayments;

    return view('dashboard.payments.index', compact('totalPayments', 'completedPayments', 'pendingPayments'));
  }

  /**
   * Datatable endpoint for payments (server side)
   */
  public function datatable(Request $request)
  {
    $query = Payment::with('invoice.project');

    // no status filter on payments; status lives on invoices only

    return DataTables::of($query)
      ->addColumn('invoice_number', function ($row) {
        return $row->invoice->invoice_number ?? '-';
      })
      ->addColumn('customer_name', function ($row) {
        return $row->invoice->project->customer_name ?? '-';
      })
      ->editColumn('amount', function ($row) {
        return 'Rp' . number_format($row->amount, 0, ',', '.');
      })
      ->editColumn('payment_date', function ($row) {
        try {
          // include hour:minute to show precise payment time
          return Carbon::parse($row->payment_date)->translatedFormat('d F Y H:i:s');
        } catch (\Exception $e) {
          return $row->payment_date;
        }
      })
      ->addColumn('action', function ($row) {
        $projectId = $row->invoice->project->id_project ?? null;
        if (!$projectId)
          return '-';

        $showUrl = route('invoices.show.project', ['project' => $projectId]);

        return '<a href="' . $showUrl . '" title="Lihat Invoice" class="bg-blue-50 p-1 rounded inline-flex items-center">'
          . '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">'
          . '<path d="M9 12h6m2 0a2 2 0 002-2V7a2 2 0 00-2-2h-6.586A2 2 0 008.586 4L6 6.586A2 2 0 004 8.586V17a2 2 0 002 2h8a2 2 0 002-2v-3" />'
          . '</svg></a>';
      })
      ->rawColumns(['action'])
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Invoice $invoice)
  {
    return view('dashboard.payments.create', compact('invoice'));

  }

  public function invoiceSelect2(Request $request)
  {
    $term = $request->get('q', '');

    $invoices = Invoice::with('project')
      ->where('remarks', '!=', 'DONE PAYMENT') // filter hanya yang belum lunas
      ->when($term, function ($q) use ($term) {
        $q->where('invoice_number', 'like', "%{$term}%")
          ->orWhere('id_invoice', 'like', "%{$term}%")
          ->orWhereHas('project', function ($p) use ($term) {
            $p->where('customer_name', 'like', "%{$term}%");
          });
      })
      ->limit(20)
      ->get();

    return response()->json([
      'results' => $invoices->map(function ($inv) {
        return [
          'id' => $inv->id_invoice,
          'text' => "{$inv->id_invoice} - {$inv->invoice_number} ({$inv->project->customer_name})",
          'payment_vat' => number_format((float) $inv->payment_vat, 2, ',', '.'),
        ];
      })
    ]);
  }

  public function invoiceDetail(Invoice $invoice)
  {
    $invoice->load('project');
    return response()->json([
      'id_invoice' => $invoice->id_invoice,
      'invoice_number' => $invoice->invoice_number,
      'customer_name' => $invoice->project->customer_name ?? '-',
      'payment_vat' => number_format((float) $invoice->payment_vat, 2, ',', '.'),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */

  public function store(Request $request)
  {
    $request->validate([
      'id_invoice' => 'required|exists:invoices,id_invoice',
      'amount' => 'required|numeric|min:1',
      'payment_date' => 'required|date',
      'pay_method' => 'nullable|string|max:50',
      'reference' => 'nullable|string|max:100',
      'notes' => 'nullable|string',
    ]);

    // Parse payment_date and ensure seconds are included
    $parsedPaymentDate = Carbon::parse($request->payment_date)->format('Y-m-d H:i:s');
    // Simpan data payment (id_payment otomatis di-generate di model)
    $payment = Payment::create([
      'id_invoice' => $request->id_invoice,
      'amount' => $request->amount,
      'payment_date' => $parsedPaymentDate,
      'pay_method' => $request->pay_method,
      'reference' => $request->reference,
      'notes' => $request->notes,
    ]);

    // Cari invoice terkait
    $invoice = Invoice::where('id_invoice', $request->id_invoice)->firstOrFail();

    $totalPaid = $invoice->payments()->sum('amount');
    $invoice->paid_amount = $totalPaid;

    if ($totalPaid == 0) {
      $invoice->remarks = 'WAITING PAYMENT';
    } elseif ($totalPaid < $invoice->payment_vat) {
      $invoice->remarks = 'PROCES PAYMENT';
      $invoice->date_payment = $parsedPaymentDate; // simpan waktu pembayaran terakhir
    } else {
      $invoice->remarks = 'DONE PAYMENT';
      $invoice->date_payment = now()->format('Y-m-d H:i:s'); // waktu lunas
    }

    $invoice->save();

    return redirect()
      ->route('payments.index')
      ->with('success', "Payment {$payment->id_payment} berhasil ditambahkan untuk Invoice {$invoice->id_invoice}");
  }


  /**
   * Display the specified resource.
   */
  public function show(Payment $payment)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Payment $payment)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdatePaymentRequest $request, Payment $payment)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Payment $payment)
  {
    //
  }
}
