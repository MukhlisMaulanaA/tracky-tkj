<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\InvoiceRequest;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{

  public function datatable(Request $request)
  {
    $query = Invoice::with('project');

    if ($request->has('remark_filter') && $request->remark_filter !== '') {
      $keyword = strtoupper($request->remark_filter);
      if ($keyword === 'DONE') {
        $query->whereRaw("UPPER(remarks) = 'DONE PAYMENT'");
      } elseif ($keyword === 'WAITING') {
        $query->whereRaw("UPPER(remarks) LIKE 'WAITING PAYMENT%'");
      } elseif ($keyword === 'PROCES') {
        $query->whereRaw("UPPER(remarks) LIKE 'PROCES PAYMENT%'");
      }
    }

    return DataTables::of($query)
      ->addColumn('remarks', function ($row) {
        $text = strtoupper($row->remarks ?? '');
        $label = 'bg-gray-100 text-gray-700 border-gray-300'; // default
  
        if ($text === 'DONE PAYMENT') {
          $label = 'bg-green-100 text-green-800 border-green-300';
        } elseif (Str::contains($text, 'WAITING PAYMENT')) {
          $label = 'bg-red-100 text-red-800 border-red-300';
        } elseif (Str::contains($text, 'PROCES PAYMENT')) {
          $label = 'bg-yellow-100 text-yellow-800 border-yellow-300';
        }

        return '<span class="inline-block px-3 py-1 rounded text-xs font-semibold border ' . $label . '">'
          . e($row->remarks)
          . '</span><br><small class="text-gray-500">Durasi: ' . ($row->duration ?? 0) . ' hari</small>';
      })
      ->addColumn('id_project', fn($row) => $row->project->id_project ?? '-')
      ->addColumn(
        'customer_name',
        function ($row) {
          $customerName = $row->project->customer_name ?? '-';
          return "<div style='min-width: 180px; white-space: normal;'>{$customerName}</div>";
        }
      )
      ->addColumn(
        'project_name',
        function ($row) {
          $projectName = $row->project->project_name ?? '-';
          return "<div style='min-width: 200px; white-space: normal;'>{$projectName}</div>";
        }
      )
      ->editColumn('amount', fn($row) => 'Rp' . number_format($row->amount, 0, ',', '.'))
      ->editColumn('vat', fn($row) => 'Rp' . number_format($row->vat, 0, ',', '.'))
      ->editColumn('pph', fn($row) => 'Rp' . number_format($row->pph, 0, ',', '.'))
      ->editColumn('denda', fn($row) => 'Rp' . number_format($row->denda, 0, ',', '.'))
      ->editColumn('payment_vat', fn($row) => 'Rp' . number_format($row->payment_vat, 0, ',', '.'))
      ->editColumn('real_payment', fn($row) => 'Rp' . number_format($row->real_payment, 0, ',', '.'))
      ->addColumn('date_details', function ($row) {
        $c = $row->create_date ? Carbon::parse($row->create_date)->translatedFormat('d F Y') : '-';
        $s = $row->submit_date ? Carbon::parse($row->submit_date)->translatedFormat('d F Y') : '-';
        $p = $row->date_payment ? Carbon::parse($row->date_payment)->translatedFormat('d F Y') : '-';

        return "<div class='text-sm leading-5 w-44'>
              <div><strong>Create:</strong> {$c}</div>
              <div><strong>Submit:</strong> {$s}</div>
              <div><strong>Payment:</strong> {$p}</div>
            </div>";
      })
      ->addColumn('action', function ($row) {
        $projectId = $row->project->id_project ?? null;
        $invoiceId = $row->id;

        if (!$projectId)
          return '-';

        $showUrl = route('invoices.show.project', ['project' => $projectId]);
        $editUrl = route('invoices.edit', $invoiceId);
        $deleteUrl = route('invoices.destroy', $invoiceId);

        return '
        <div class="flex items-center space-x-3">
          <a href="' . $showUrl . '" title="Lihat Detail" class="bg-blue-50 p-1 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M9 12h6m2 0a2 2 0 002-2V7a2 2 0 00-2-2h-6.586A2 2 0 008.586 4L6 6.586A2 2 0 004 8.586V17a2 2 0 002 2h8a2 2 0 002-2v-3" />
            </svg>
          </a>
          <a href="' . $editUrl . '" title="Edit Invoice" class="bg-green-50 p-1 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536z" />
            </svg>
          </a>
          <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus invoice ini?\')" class="bg-red-50 p-1 rounded inline">
            ' . csrf_field() . method_field('DELETE') . '
            <button type="submit" title="Hapus Invoice">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </form>
        </div>';
      })
      ->rawColumns([
        'remarks',
        'date_details',
        'customer_name',
        'project_name',
        'action',
      ])
      ->make(true);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $invoices = Invoice::all();
    return view('dashboard.invoices.index', compact('invoices'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Invoice $invoice)
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

    return view('dashboard.invoices.create', compact('years', 'projects', 'invoice', 'projectSuggestions', 'customerSuggestions'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(InvoiceRequest $request)
  {
    // Bersihkan nilai rupiah ke angka
    $amount = (float) str_replace(',', '', $request->amount);
    $pphPercent = (float) $request->pph_percent;
    $denda = $request->denda ? (float) str_replace(',', '', $request->denda) : 0;

    // Hitung nilai-nilai
    $vat = round($amount * 0.11);
    $pph = round($amount * ($pphPercent / 100));
    $paymentVat = $amount + $vat;
    $realPayment = $amount - $pph - $denda;

    $datePayment = $request->remarks === 'DONE PAYMENT' ? Carbon::now() : null;
    // pass datePayment to helper so calculation is based on payment date when available
    $duration = $this->calculateDuration($request->remarks, $request->submit_date, $datePayment);

    // dd($request->id_project);

    Invoice::create([
      'id_project' => $request->id_project,
      'year' => $request->year,
      'create_date' => $request->create_date,
      'submit_date' => $request->submit_date,
      'date_payment' => $datePayment,
      'duration' => $duration,
      'po_number' => $request->po_number,
      'invoice_number' => $request->invoice_number,
      'remarks' => $request->remarks,
      'notes' => $request->notes,
      'amount' => $amount,
      'vat' => $vat,
      'pph' => $pph,
      'denda' => $denda,
      'payment_vat' => $paymentVat,
      'real_payment' => $realPayment,
    ]);

    // dd($request);

    return redirect()->route('invoices.index')->with('success', 'Invoice berhasil disimpan.');
  }

  /**
   * Display the specified resource.
   */
  // public function show(Invoice $id_project)
  // {
  //   return view('invoices.show', compact('invoice'));

  // }

  public function showByProject($project)
  {
    $invoice = Invoice::whereHas('project', function ($query) use ($project) {
      $query->where('id_project', $project);
    })->firstOrFail();

    $invoice->load('project'); // Call relation

    $createDate = Carbon::parse($invoice->create_date)->translatedFormat('d F Y');
    $submitDate = Carbon::parse($invoice->submit_date)->translatedFormat('d F Y');
    $paymentDate = $invoice->date_payment ? Carbon::parse($invoice->date_payment)->translatedFormat('d F Y') : '-';
    // dd($paymentDate);

    // Generate badge HTML
    $remark = strtoupper($invoice->remarks);
    $badgeClass = match (true) {
      $remark === 'DONE PAYMENT' => 'bg-green-100 text-green-800',
      str_starts_with($remark, 'PROCES PAYMENT') => 'bg-yellow-100 text-yellow-800',
      str_starts_with($remark, 'WAITING PAYMENT') => 'bg-red-100 text-red-800',
      default => 'bg-gray-100 text-gray-800',
    };

    $invoice->remark_badge = "<span class='px-3 py-1 rounded-full text-sm font-medium {$badgeClass}'>{$invoice->remarks}</span>";

    return view('dashboard.invoices.show', compact('invoice', 'createDate', 'submitDate', 'paymentDate'));
  }


  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Invoice $invoice)
  {
    $projects = Project::all();
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
    // dd($invoice->remarks);

    return view('dashboard.invoices.edit', compact('invoice', 'projects', 'years', 'projectSuggestions', 'customerSuggestions'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(InvoiceRequest $request, Invoice $invoice)
  {
    // Bersihkan nilai rupiah ke angka
    $amount = (float) str_replace(',', '', $request->amount);
    $pphPercent = (float) $request->pph_percent;
    $denda = $request->denda ? (float) str_replace(',', '', $request->denda) : 0;

    // Hitung ulang
    $vat = round($amount * 0.11);
    $pph = round($amount * ($pphPercent / 100));
    $paymentVat = $amount + $vat;
    $realPayment = $amount - $pph - $denda;

    // Tentukan date_payment
    if ($request->remarks === 'DONE PAYMENT') {
      // Kalau sebelumnya belum ada date_payment, set sekarang
      $datePayment = $invoice->date_payment ?? Carbon::now();
    } else {
      $datePayment = $invoice->date_payment; // biarkan tetap
    }

    // Calculate duration using helper which handles future submit dates and bounds the value
    $duration = $this->calculateDuration($request->remarks, $request->submit_date, $datePayment);

    $invoice->update([
      'id_project' => $request->id_project,
      'year' => $request->year,
      'create_date' => $request->create_date,
      'submit_date' => $request->submit_date,
      'date_payment' => $datePayment,
      'duration' => $duration,
      'po_number' => $request->po_number,
      'invoice_number' => $request->invoice_number,
      'remarks' => $request->remarks,
      'notes' => $request->notes,
      'amount' => $amount,
      'vat' => $vat,
      'pph' => $pph,
      'denda' => $denda,
      'payment_vat' => $paymentVat,
      'real_payment' => $realPayment,
    ]);

    return redirect()->route('invoices.index')->with('success', 'Invoice berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Invoice $invoice)
  {
    $invoice->delete();
    return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
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

  private function calculateDuration($remarks, $submitDate)
  {
    // This helper now accepts an optional 3rd param (datePayment) if provided.
    // Signature fallback kept for compatibility.
    $args = func_get_args();
    $datePayment = $args[2] ?? null;

    if (empty($submitDate)) {
      return null;
    }

    try {
      $submit = Carbon::parse($submitDate);
    } catch (\Exception $e) {
      return null;
    }

    // reference date is payment date when provided, otherwise now
    try {
      $reference = $datePayment ? Carbon::parse($datePayment) : Carbon::now();
    } catch (\Exception $e) {
      $reference = Carbon::now();
    }

    // Get signed difference (negative if submit is in the future relative to reference)
    $signedDiff = $reference->diffInDays($submit, false);

    // Do not allow negative durations (store 0 instead)
    $duration = $signedDiff < 0 ? 0 : $signedDiff;

    // Clamp to a reasonable upper bound to avoid DB column overflow (e.g., 10k days ~ 27 years)
    $maxAllowed = 10000;
    if ($duration > $maxAllowed) {
      $duration = $maxAllowed;
    }

    return $duration;
  }
}
