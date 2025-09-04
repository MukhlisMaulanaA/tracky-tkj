<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
          'text' => "{$inv->id_invoice} - {$inv->invoice_number} ({$inv->project->customer_name})"
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
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request, Invoice $invoice)
  {
    $request->validate([
      'amount' => 'required|numeric|min:1',
      'payment_date' => 'required|date',
      'method' => 'nullable|string|max:50',
      'reference' => 'nullable|string|max:100',
      'notes' => 'nullable|string',
    ]);

    // Hitung total yang sudah dibayar
    $totalPaid = $invoice->payments()->sum('amount');
    $outstanding = max(0, ($invoice->real_payment ?? 0) - $totalPaid);

    if ($outstanding <= 0 || $invoice->remarks === 'DONE PAYMENT') {
      return back()->withErrors(['amount' => 'Invoice sudah lunas.'])->withInput();
    }
    if ($request->amount > $outstanding) {
      return back()->withErrors(['amount' => 'Nominal melebihi sisa tagihan (Rp' . number_format($outstanding, 0, ',', '.') . ').'])->withInput();
    }

    // dd($request);

    // Buat payment (FK id_invoice diisi otomatis dari relasi)
    $invoice->payments()->create([
      'amount' => $request->amount,
      'payment_date' => $request->payment_date,
      'pay_method' => $request->pay_method,
      'reference' => $request->reference,
      'notes' => $request->notes,
    ]);

    // Recalculate status
    $newTotalPaid = $invoice->payments()->sum('amount');
    $target = (float) ($invoice->real_payment ?? 0);

    if ($newTotalPaid <= 0) {
      $invoice->remarks = 'WAITING PAYMENT';
    } elseif ($newTotalPaid < $target) {
      $percentage = $target > 0 ? round(($newTotalPaid / $target) * 100) : 0;
      $invoice->remarks = "PROCES PAYMENT {$percentage}%";
    } else {
      $invoice->remarks = 'DONE PAYMENT';
      $invoice->date_payment = $request->payment_date; // opsional: set tanggal lunas
    }

    $invoice->save();

    return redirect()
      ->route('payments.index') // pastikan route ini ada; kalau belum, arahkan ke create/detail
      ->with('success', 'Payment berhasil ditambahkan.');
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
