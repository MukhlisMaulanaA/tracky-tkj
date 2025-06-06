<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request): View
  {
    return view('dashboard.index');
  }

  public function invoices(Request $request): View
  {
    return view('dashboard.invoice');
  }

  public function salaries(Request $request): View
  {
    return view('dashboard.salary');
  }
}
