<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{

  public function datatable(Request $request)
  {
    $query = Invoice::query();
    if ($request->has('remark_filter') && $request->remark_filter !== '') {
      $keyword = strtoupper($request->remark_filter);
      if ($keyword === 'DONE') {
        $query->whereRaw("UPPER(remark) = 'DONE PAYMENT'");
      } elseif ($keyword === 'WAITING') {
        $query->whereRaw("UPPER(remark) LIKE 'WAITING PAYMENT%'");
      } elseif ($keyword === 'PROCES') {
        $query->whereRaw("UPPER(remark) LIKE 'PROCES PAYMENT%'");
      }
    }
    return DataTables::of($query)
      ->addColumn('remark', function ($row) {
        $text = strtoupper($row->remark ?? '');
        $label = 'bg-gray-100 text-gray-700 border-gray-300'; // default
  
        if ($text === 'DONE PAYMENT') {
          $label = 'bg-green-100 text-green-800 border-green-300';
        } elseif (Str::contains($text, 'WAITING PAYMENT')) {
          $label = 'bg-red-100 text-red-800 border-red-300';
        } elseif (Str::contains($text, 'PROCES PAYMENT')) {
          $label = 'bg-yellow-100 text-yellow-800 border-yellow-300';
        }

        return '<span class="inline-block px-2 py-1 rounded border text-xs font-semibold ' . $label . '">' .
          e($row->remark) . '</span>';
      })
      ->editColumn('amount', fn($row) => 'Rp' . number_format($row->amount, 0, ',', '.'))
      ->editColumn('vat_11', fn($row) => 'Rp' . number_format($row->vat_11, 0, ',', '.'))
      ->editColumn('pph_2', fn($row) => 'Rp' . number_format($row->pph_2, 0, ',', '.'))
      ->editColumn('payment_vat', fn($row) => 'Rp' . number_format($row->payment_vat, 0, ',', '.'))
      ->editColumn('real_payment', fn($row) => 'Rp' . number_format($row->real_payment, 0, ',', '.'))
      ->editColumn('create_tanggal', fn($row) => optional($row->create_tanggal)->format('d M Y'))
      ->editColumn('submit_tanggal', fn($row) => optional($row->submit_tanggal)->format('d M Y'))
      ->editColumn('date_payment', fn($row) => optional($row->date_payment)->format('d M Y'))
      ->rawColumns(['remark']) // Tampilkan HTML badge remark
      ->make(true);
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $invoices = Invoice::all();
    return view('dashboard.invoice.index', compact('invoices'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'no' => 'required|integer',
      'tahun' => 'required|integer',
      'project' => 'required|string',
      'create_tanggal' => 'nullable|date',
      'submit_tanggal' => 'nullable|date',
      'no_po' => 'required|string',
      'no_invoice' => 'required|string',
      'remark' => 'nullable|string',
      'costumer' => 'required|string',
      'amount' => 'required|numeric',
      'denda' => 'nullable|numeric',
      'date_payment' => 'nullable|date',
    ]);

    $amount = $validated['amount'];
    $vat = $amount * 0.11;
    $pph = $amount * 0.02;

    $validated['vat_11'] = $vat;
    $validated['pph_2'] = $pph;
    $validated['payment_vat'] = $amount + $vat;
    $validated['real_payment'] = $amount - $pph;

    Invoice::create($validated);

    return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Invoice $invoice)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Invoice $invoice)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Invoice $invoice)
  {
    $validated = $request->validate([
      'no' => 'required|integer',
      'tahun' => 'required|integer',
      'project' => 'required|string',
      'create_tanggal' => 'nullable|date',
      'submit_tanggal' => 'nullable|date',
      'no_po' => 'required|string',
      'no_invoice' => 'required|string',
      'remark' => 'nullable|string',
      'costumer' => 'required|string',
      'amount' => 'required|numeric',
      'denda' => 'nullable|numeric',
      'date_payment' => 'nullable|date',
    ]);

    $amount = $validated['amount'];
    $vat = $amount * 0.11;
    $pph = $amount * 0.02;

    $validated['vat_11'] = $vat;
    $validated['pph_2'] = $pph;
    $validated['payment_vat'] = $amount + $vat;
    $validated['real_payment'] = $amount - $pph;

    $invoice->update($validated);

    return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Invoice $invoice)
  {
    //
  }
}
