<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

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
        $buttons = '';

        // 🔹 Jika ada bukti pembayaran
        if (!empty($row->proof_image)) {
          $proofUrl = asset('storage/' . ltrim($row->proof_image, '/'));
          $buttons .= '<button type="button" 
                        class="view-proof-btn inline-flex items-center p-1 text-xs text-white bg-blue-600 rounded" 
                        title="Lihat Bukti" 
                        data-proof="' . $proofUrl . '">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>';
        }

        // 🔹 Tombol Hapus Payment
        $deleteUrl = route('payments.destroy', $row->id_payment);
        $buttons .= '
        <form action="' . $deleteUrl . '" method="POST" class="inline ml-1" onsubmit="return confirm(\'Hapus payment ini?\')">
            ' . csrf_field() . method_field('DELETE') . '
            <button type="submit" 
                    class="inline-flex items-center p-1 text-xs text-white bg-red-600 rounded" 
                    title="Hapus Payment">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </form>';

        return $buttons ?: '-';
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
      'proof_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // max 2MB
    ]);

    // Parse payment_date and ensure seconds are included
    $parsedPaymentDate = Carbon::parse($request->payment_date)->format('Y-m-d H:i:s');
    // Simpan data payment (id_payment otomatis di-generate di model)
    $paymentData = [
      'id_invoice' => $request->id_invoice,
      'amount' => $request->amount,
      'payment_date' => $parsedPaymentDate,
      'pay_method' => $request->pay_method,
      'reference' => $request->reference,
      'notes' => $request->notes,
    ];

    // handle proof image upload
    if ($request->hasFile('proof_image') && $request->file('proof_image')->isValid()) {
      // store in storage/app/public/images
      $path = $request->file('proof_image')->store('images', 'public');
      // save stored path (relative to storage/app/public)
      $paymentData['proof_image'] = $path;
    }

    $payment = Payment::create($paymentData);

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

    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
      'secret' => env('RECAPTCHA_SECRET_KEY'),
      'response' => $request->input('g-recaptcha-response'),
      'remoteip' => $request->ip(),
    ]);

    if (!($response->json()['success'] ?? false)) {
      return back()->withErrors([
        'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Coba lagi.'
      ])->withInput();
    }

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
    $invoice = $payment->invoice; // relasi ke invoice

    // hapus payment
    $payment->delete();

    // hitung ulang total pembayaran
    $totalPaid = $invoice->payments()->sum('amount');
    $invoice->paid_amount = $totalPaid;

    if ($totalPaid == 0) {
      $invoice->remarks = 'WAITING PAYMENT';
    } elseif ($totalPaid < $invoice->payment_vat) {
      $invoice->remarks = 'PROCES PAYMENT';
    } else {
      $invoice->remarks = 'DONE PAYMENT';
    }

    // reset date_payment kalau belum lunas
    $invoice->date_payment = ($totalPaid >= $invoice->payment_vat)
      ? now()
      : null;

    $invoice->save();

    return redirect()->route('payments.index')
      ->with('success', "Payment berhasil dihapus dan invoice {$invoice->id_invoice} diperbarui.");
  }
}
