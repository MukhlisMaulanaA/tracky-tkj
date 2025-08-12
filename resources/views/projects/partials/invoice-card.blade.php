<div class="bg-white shadow rounded-lg p-6 mb-4">
  <div class="flex items-center space-x-3 mb-6">
    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
      <x-icon name="dollar-sign" class="w-6 h-6 text-blue-600"></x-icon>
    </div>
    <h2 class="text-lg font-semibold text-gray-900">Invoice Details</h2>
  </div>
  @if ($invoice)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Project ID -->
      <div>
        <label class="text-sm font-medium text-gray-500 mb-1 block">No. Invoice</label>
        <p class="text-base font-semibold text-gray-900">{{ $invoice->invoice_number }}</p>
      </div>

      <!-- Project Name -->
      <div>
        <label class="text-sm font-medium text-gray-500 mb-1 block">Tenggat Pembayaran</label>
        <p class="text-base font-semibold text-gray-900">{{ $invoice->date_payment }}</p>
      </div>

      <!-- Customer Name -->
      <div>
        <label class="text-sm font-medium text-gray-500 mb-1 block">Value</label>
        <p class="text-base font-semibold text-gray-900">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>

      </div>

      <!-- Location -->
      <div>
        <label class="text-sm font-medium text-gray-500 mb-1 block">Lokasi</label>
        <p class="text-base font-semibold text-gray-900">{{ $project->location }}</p>
      </div>

      <!-- Status -->
      <div>
        <label class="text-sm font-medium text-gray-500 mb-1 block">Status</label>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
          <i class="fas fa-circle text-yellow-400 mr-1 text-xs"></i>
          {{ $invoice->remarks }}
        </span>
      </div>

    </div>
</div>
@else
<div class="text-gray-500">No invoice found for this project.</div>
@endif
</div>
