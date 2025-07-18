@extends('layouts.dashboard')

@section('content')
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 mb-6">
      <div class="flex items-center justify-between px-4 py-4">
        <div class="flex items-center space-x-3">
          <div class="bg-blue-600 p-2 rounded-lg">
            <x-icon name="file-text" class="w-6 h-6 text-white" />
          </div>
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Invoice Management System</h1>
            <p class="text-sm text-gray-600">Professional Invoice Details</p>
          </div>
        </div>
        <div class="flex space-x-2">
          <a href="{{ route('invoices.index') }}"
            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
            <x-icon name="arrow-left" class="w-4 h-4" />
            <span>Kembali</span>
          </a>
          <button onclick="window.print()"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
            <x-icon name="printer" class="w-4 h-4" />
            <span>Print</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Invoice Details -->
    <div class="bg-white rounded-lg shadow p-6 space-y-8">
      <!-- Status -->
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">Invoice Details</h2>
          <p class="text-sm text-gray-600">Complete financial information and payment status</p>
        </div>
        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
          {{ $invoice->remark }}
        </span>
      </div>

      <!-- Grid Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Project Info -->
        <div class="bg-gray-50 p-4 rounded-md">
          <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <x-icon name="file-text" class="w-5 h-5 mr-2 text-blue-600"></x-icon>
            Project Information
          </h2>
          <div>
            <label class="text-sm font-medium text-gray-500">Project ID</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->project->id_project ?? '-' }}</p>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Customer</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->project->customer_name ?? '-' }}</p>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Project</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->project->project_name ?? '-' }}</p>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">PO Number</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->project->po_number ?? '-' }}</p>
          </div>
        </div>

        <!-- Invoice Dates -->
        <div class="bg-gray-50 p-4 rounded-md">
          <h3 class="font-semibold text-gray-700 mb-3">Invoice Details</h3>
          <div>
            <label class="text-sm font-medium text-gray-500">No</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->invoice_number ?? '-' }}</p>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Creation Date</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->create_date ?? '-' }}</p>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Submission</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->submit_date ?? '-' }}</p>
          </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-gray-50 p-4 rounded-md">
          <h3 class="font-semibold text-gray-700 mb-3">Payment</h3>
          <div>
            <label class="text-sm font-medium text-gray-500">Status</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->remark ?? '-' }}</p>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Payment Date</label>
            <p class="text-lg font-semibold text-gray-900">{{ $invoice->date_payment ?? '-' }}</p>
          </div>
        </div>
      </div>

      <!-- Financial Breakdown -->
      <div class="bg-blue-50 p-6 rounded-md">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">Financial Breakdown</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Base Amount</span>
              <span class="font-semibold">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
              <span>VAT</span>
              <span class="font-semibold">Rp{{ number_format($invoice->vat_11, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
              <span>PPH</span>
              <span class="font-semibold text-red-600">-Rp{{ number_format($invoice->pph_2, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
              <span>Penalty</span>
              <span
                class="font-semibold">{{ $invoice->denda ? 'Rp' . number_format($invoice->denda, 0, ',', '.') : 'Tidak Ada' }}</span>
            </div>
          </div>
          <div class="p-4 bg-white border rounded-md text-center">
            <p class="text-gray-600 text-sm mb-2">Final Payment</p>
            <p class="text-3xl font-bold text-green-600 mb-1">Rp{{ number_format($invoice->real_payment, 0, ',', '.') }}
            </p>
            <p class="text-sm text-gray-500">Paid on {{ $invoice->date_payment }}</p>
          </div>
        </div>
      </div>

      <!-- Summary Steps -->
      <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 text-sm text-yellow-800 space-y-1">
        <p><strong>Langkah 1:</strong> Base Amount: Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
        <p><strong>Langkah 2:</strong> + VAT ({{ $invoice->vat_11 }})</p>
        <p><strong>Langkah 3:</strong> - PPH ({{ $invoice->pph_2 }})</p>
        <p><strong>Akhir:</strong> Real Payment:
          <strong>Rp{{ number_format($invoice->real_payment, 0, ',', '.') }}</strong>
        </p>
      </div>
    </div>
  </div>
@endsection
