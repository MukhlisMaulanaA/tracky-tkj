<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\InvoiceRequest;
use App\Models\Project;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{

  public function datatable(Request $request)
  {
    $query = Invoice::with('project');

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
      ->addColumn('customer_name', fn($row) => $row->project->customer_name ?? '-')
      ->addColumn('project_name', fn($row) => $row->project->project_name ?? '-')
      ->addColumn('id_project', fn($row) => $row->project->id_project ?? '-')
      ->editColumn('amount', fn($row) => 'Rp' . number_format($row->amount, 0, ',', '.'))
      ->editColumn('vat_11', fn($row) => 'Rp' . number_format($row->vat_11, 0, ',', '.'))
      ->editColumn('pph_2', fn($row) => 'Rp' . number_format($row->pph_2, 0, ',', '.'))
      ->editColumn('denda', fn($row) => 'Rp' . number_format($row->denda, 0, ',', '.'))
      ->editColumn('payment_vat', fn($row) => 'Rp' . number_format($row->payment_vat, 0, ',', '.'))
      ->editColumn('real_payment', fn($row) => 'Rp' . number_format($row->real_payment, 0, ',', '.'))
      ->editColumn('create_date', fn($row) => optional($row->create_date)->format('d M Y'))
      ->editColumn('submit_date', fn($row) => optional($row->submit_date)->format('d M Y'))
      ->editColumn('date_payment', fn($row) => optional($row->date_payment)->format('d M Y'))
      ->rawColumns(['remark'])
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
    $projects = Project::all();
    // dd($projects);
    $years = collect(range(date('Y'), date('Y') - 9))
      ->mapWithKeys(fn($year) => [$year => $year])
      ->toArray();

    $projectSuggestions = [
      'Digital Transformation Project',
      'Website Development',
      'Mobile App Development',
      'System Integration',
      'Cloud Migration',
      'Data Analytics Platform'
    ];

    $customerSuggestions = [
      'PT. Technology Solutions',
      'CV. Digital Innovation',
      'PT. Global Systems',
      'PT. Smart Industries',
      'CV. Tech Partners'
    ];

    return view('dashboard.invoice.create', compact('years', 'projects', 'projectSuggestions', 'customerSuggestions'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(InvoiceRequest $request)
  {
    DB::beginTransaction();

    try {
      $invoice = Invoice::create([
        'sequential_number' => $request->sequential_number,
        'year' => $request->year,
        'project_name' => $request->project_name,
        'create_date' => $request->create_date,
        'submit_date' => $request->submit_date,
        'date_payment' => $request->date_payment,
        'po_number' => $request->po_number,
        'invoice_number' => $request->invoice_number,
        'remark' => $request->remark,
        'customer_name' => $request->customer_name,
        'amount' => $this->parseCurrency($request->amount),
        'vat_11' => $this->parseCurrency($request->vat_11),
        'pph_2' => $this->parseCurrency($request->pph_2),
        'fine' => $this->parseCurrency($request->fine),
        'payment_vat' => $this->parseCurrency($request->payment_vat),
        'real_payment' => $this->parseCurrency($request->real_payment),
      ]);

      DB::commit();

      // Always return JSON for AJAX requests
      if ($request->expectsJson() || $request->ajax()) {
        return response()->json([
          'success' => true,
          'message' => 'Payment form submitted successfully!',
          'redirect' => route('invoice.show', $invoice->id)
        ]);
      }

      return redirect()
        ->route('invoice.show', $invoice)
        ->with('success', 'Payment form submitted successfully!');

    } catch (\Exception $e) {
      DB::rollBack();

      Log::error('Payment creation failed: ' . $e->getMessage());

      if ($request->expectsJson() || $request->ajax()) {
        return response()->json([
          'success' => false,
          'message' => 'An error occurred while saving the payment.',
          'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
      }

      return back()
        ->withInput()
        ->with('error', 'An error occurred while saving the payment.');
    }
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
    $years = collect(range(date('Y'), date('Y') - 9))
      ->mapWithKeys(fn($year) => [$year => $year])
      ->toArray();

    $projectSuggestions = [
      'Digital Transformation Project',
      'Website Development',
      'Mobile App Development',
      'System Integration',
      'Cloud Migration',
      'Data Analytics Platform'
    ];

    $customerSuggestions = [
      'PT. Technology Solutions',
      'CV. Digital Innovation',
      'PT. Global Systems',
      'PT. Smart Industries',
      'CV. Tech Partners'
    ];

    return view('payment.form', compact('invoice', 'years', 'projectSuggestions', 'customerSuggestions'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(InvoiceRequest $request, Invoice $invoice)
  {
    DB::beginTransaction();

    try {
      $invoice->update([
        'sequential_number' => $request->sequential_number,
        'year' => $request->year,
        'project_name' => $request->project_name,
        'create_date' => $request->create_date,
        'submit_date' => $request->submit_date,
        'date_payment' => $request->date_payment,
        'po_number' => $request->po_number,
        'invoice_number' => $request->invoice_number,
        'remark' => $request->remark,
        'customer_name' => $request->customer_name,
        'amount' => $this->parseCurrency($request->amount),
        'vat_11' => $this->parseCurrency($request->vat_11),
        'pph_2' => $this->parseCurrency($request->pph_2),
        'fine' => $this->parseCurrency($request->fine),
        'payment_vat' => $this->parseCurrency($request->payment_vat),
        'real_payment' => $this->parseCurrency($request->real_payment),
      ]);

      DB::commit();

      if ($request->ajax()) {
        return response()->json([
          'success' => true,
          'message' => 'Payment updated successfully!',
          'redirect' => route('payment.show', $invoice)
        ]);
      }

      return redirect()
        ->route('payment.show', $invoice)
        ->with('success', 'Payment updated successfully!');

    } catch (\Exception $e) {
      DB::rollBack();

      if ($request->ajax()) {
        return response()->json([
          'success' => false,
          'message' => 'An error occurred while updating the payment.'
        ], 500);
      }

      return back()
        ->withInput()
        ->with('error', 'An error occurred while updating the payment.');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Invoice $invoice)
  {
    //
  }

  private function parseCurrency($value)
  {
    if (empty($value))
      return 0;

    // Remove currency formatting (Rp, dots for thousands, spaces)
    $value = str_replace(['Rp', '.', ' '], '', $value);
    // Replace comma with period for decimal (if any)
    $value = str_replace(',', '.', $value);

    return (float) $value;
  }
}
