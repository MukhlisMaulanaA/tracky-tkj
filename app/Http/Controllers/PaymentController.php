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

    $invoice->payments()->create([
      'amount' => $request->amount,
      'payment_date' => $request->payment_date,
      'pay_method' => $request->pay_method,
      'reference' => $request->reference,
      'notes' => $request->notes,
    ]);

    // update remarks invoice otomatis
    $totalPaid = $invoice->payments()->sum('amount');
    if ($totalPaid == 0) {
      $invoice->remarks = 'WAITING PAYMENT';
    } elseif ($totalPaid < $invoice->real_payment) {
      $percentage = round(($totalPaid / $invoice->real_payment) * 100);
      $invoice->remarks = "PROCES PAYMENT {$percentage}%";
    } else {
      $invoice->remarks = 'DONE PAYMENT';
    }
    $invoice->save();

    return redirect()
      // ->route('payments.show', $invoice->id_project)
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
