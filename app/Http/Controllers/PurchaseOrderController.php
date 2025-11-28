<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderController extends Controller
{
  public function index()
  {
    $purchaseOrders = PurchaseOrder::with('project')->orderByDesc('created_at')->get();
    return view('dashboard.purchaseOrder.index', compact('purchaseOrders'));
  }

  public function create(PurchaseOrder $purchaseOrder)
  {
    $projects = Project::all();

    // Generate suggested id_po similar to invoices but with PO prefix
    $yearShort = date('y');
    $monthIndex = (int) date('n');
    $monthLetter = chr(ord('A') + ($monthIndex - 1));

    $prefix = sprintf('PO%s%s', $yearShort, $monthLetter);
    $last = PurchaseOrder::where('id_po', 'like', $prefix . '%')
      ->orderBy('id_po', 'desc')
      ->first();

    if ($last) {
      $lastSeq = (int) substr($last->id_po, -3);
      $seq = $lastSeq + 1;
    } else {
      $seq = 1;
    }

    $suggestedId = sprintf('%s%03d', $prefix, $seq);
    $purchaseOrder->id_po = $suggestedId;

    return view('dashboard.purchaseOrder.create', compact('projects', 'purchaseOrder'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'po_number' => 'required|string|max:255',
      'project_id' => 'required|string',
      'created_date' => 'required|date',
      'total_value' => 'nullable|numeric',
      'status' => 'required|string',
      'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
      'note' => 'nullable|string',
    ]);

    // Ensure id_po is generated server-side for safety
    $yearShort = date('y');
    $monthIndex = (int) date('n');
    $monthLetter = chr(ord('A') + ($monthIndex - 1));
    $prefix = sprintf('PO%s%s', $yearShort, $monthLetter);
    $last = PurchaseOrder::where('id_po', 'like', $prefix . '%')
      ->orderBy('id_po', 'desc')
      ->first();

    if ($last) {
      $lastSeq = (int) substr($last->id_po, -3);
      $seq = $lastSeq + 1;
    } else {
      $seq = 1;
    }

    $idPo = sprintf('%s%03d', $prefix, $seq);

    $data = [
      'id_po' => $idPo,
      'po_number' => $request->po_number,
      'project_id' => $request->project_id,
      'created_date' => $request->created_date,
      'total_value' => $request->total_value,
      'status' => $request->status,
      'note' => $request->note,
    ];

    if ($request->hasFile('document')) {
      $path = $request->file('document')->store('purchase_orders', 'public');
      $data['document'] = $path;
    }

    PurchaseOrder::create($data);

    return redirect()->route('purchase_orders.index')->with('success', 'Purchase order berhasil disimpan.');
  }

  public function show($id)
  {
    $purchaseOrder = PurchaseOrder::with('project', 'items')->where('id_po', $id)->firstOrFail();
    return view('dashboard.purchaseOrder.show', compact('purchaseOrder'));
  }
}
