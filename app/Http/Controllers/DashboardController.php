<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
  public function index(Request $request): View
  {
    // Total pembayaran yang sudah dilakukan
    $totalPaid = Invoice::sum('paid_amount');
    $totalPaidIDR = 'Rp' . number_format($totalPaid, 0, ',', '.');

    // Total tagihan dikurangi yang sudah dibayar
    $totalInvoiceAmount = Invoice::sum('payment_vat');
    $unpaidAmount = $totalInvoiceAmount - $totalPaid;
    $unpaidAmountIDR = 'Rp' . number_format($unpaidAmount, 0, ',', '.');


    // Total project
    $totalProject = Project::count();

    // Total invoice belum lunas
    $pendingInvoices = Invoice::where('remarks', '!=', 'DONE PAYMENT')->count();

    // Recent invoices (4 latest by create_date or created_at)
    $recentInvoices = Invoice::with('project')
      ->orderByDesc('create_date')
      ->orderByDesc('created_at')
      ->limit(4)
      ->get();

    // Recent payments (4 latest)
    $recentPayments = Payment::with('invoice')
      ->orderByDesc('payment_date')
      ->orderByDesc('created_at')
      ->limit(4)
      ->get();

    return view('dashboard.index', [
      'totalPaid' => $totalPaid,
      'totalPaidIDR' => $totalPaidIDR,
      'unpaidAmount' => $unpaidAmount,
      'unpaidAmountIDR' => $unpaidAmountIDR,
      'totalProject' => $totalProject,
      'pendingInvoices' => $pendingInvoices,
      'recentInvoices' => $recentInvoices,
      'recentPayments' => $recentPayments,
    ]);
  }


  // public function invoices(Request $request): View
  // {
  //   return view('dashboard.invoice');
  // }

  public function salaries(Request $request): View
  {
    return view('dashboard.salary');
  }
}
