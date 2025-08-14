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
        <label class="text-sm font-medium text-gray-500 mb-1 block">Tanggal Submit</label>
        <p class="text-base font-semibold text-gray-900">{{ $submitDate }}</p>
      </div>

      <!-- Customer Name -->
      <div>
        <label class="text-sm font-medium text-gray-500 mb-1 block">Value</label>
        <p class="text-base font-semibold text-gray-900">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>

      </div>

      <!-- Location -->
      <div>
        <label class="text-sm font-medium text-gray-500 mb-1 block">PO. Number</label>
        <p class="text-base font-semibold text-gray-900">{{ $invoice->po_number }}</p>
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

    <!-- Accordion: Financial breakdown -->
    <div class="mt-4">
      <details class="border border-gray-200 rounded-md">
        <summary class="px-4 py-3 cursor-pointer bg-gray-50 rounded-md flex items-center justify-between">
          <div class="flex items-center space-x-2">
            <x-icon name="chevrons-down" class="w-4 h-4 text-gray-600" />
            <span class="font-medium text-gray-800">Lihat Rincian Pembayaran</span>
          </div>
          <span class="text-sm text-gray-500">Klik untuk buka</span>
          <span class="text-sm text-gray-500">Klik untuk buka</span>
        </summary>
        <div class="p-4 bg-white">
          @php
            // Fallbacks for different column names
            $vat = $invoice->vat_11 ?? ($invoice->vat ?? 0);
            $pph = $invoice->pph_2 ?? ($invoice->pph ?? 0);
            $denda = $invoice->denda ?? 0;
            $paymentVat = $invoice->payment_vat ?? $invoice->amount + $vat;
            $realPayment = $invoice->real_payment ?? $invoice->amount - $pph - $denda;
          @endphp

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
              <div class="flex justify-between">
                <span>Base Amount</span>
                <span class="font-semibold">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-between">
                <span>VAT</span>
                <span class="font-semibold">Rp{{ number_format($vat, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-between">
                <span>PPH</span>
                <span class="font-semibold text-red-600">-Rp{{ number_format($pph, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-between">
                <span>Penalty</span>
                <span
                  class="font-semibold">{{ $denda ? 'Rp' . number_format($denda, 0, ',', '.') : 'Tidak Ada' }}</span>
              </div>
              <div class="border-t border-gray-200 pt-3">
                <div class="flex justify-between items-center"><span class="text-gray-700 font-medium">Payment with
                    VAT</span><span
                    class="text-blue-600 font-bold">Rp{{ number_format($paymentVat, 0, ',', '.') }}</span></div>
              </div>
            </div>

            <div class="p-4 bg-gray-50 border rounded-md text-center">
              <p class="text-gray-600 text-sm mb-2">Final Payment</p>
              <p class="text-2xl font-bold text-green-600 mb-1">Rp{{ number_format($realPayment, 0, ',', '.') }}</p>
              <p class="text-sm text-gray-500">Paid on {{ $invoice->date_payment ?? '-' }}</p>
            </div>
          </div>

        </div>
      </details>
    </div>

    </div>
    @else
    <div class="text-gray-500">No invoice found for this project.</div>
    @endif
</div>
