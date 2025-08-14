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

        @php
          $text = strtoupper($invoice->remarks ?? '');
          $label = 'bg-gray-100 text-gray-700 border-gray-300';
          $iconColor = 'text-gray-400';

          if ($text === 'DONE PAYMENT') {
            $label = 'bg-green-100 text-green-800 border-green-300';
            $iconColor = 'text-green-400';
          } elseif (str_starts_with($text, 'PROCES PAYMENT')) {
            $label = 'bg-yellow-100 text-yellow-800 border-yellow-300';
            $iconColor = 'text-yellow-400';
          } elseif (str_starts_with($text, 'WAITING PAYMENT')) {
            $label = 'bg-red-100 text-red-800 border-red-300';
            $iconColor = 'text-red-400';
          }
        @endphp

        <span class="inline-block px-3 py-1 rounded text-xs font-semibold border {{ $label }}">
          <i class="fas fa-circle {{ $iconColor }} mr-1 text-xs"></i>
          {{ $invoice->remarks }}
        </span>

      </div>

    </div>
</div>
@else
<div class="text-gray-500">No invoice found for this project.</div>
@endif
</div>
