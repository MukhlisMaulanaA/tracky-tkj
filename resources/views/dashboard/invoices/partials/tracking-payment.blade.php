<div class="bg-green-50 rounded-xl shadow-sm p-6">
  <!-- Header -->
  <div class="flex items-center gap-2 mb-6">
    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd"
        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
        clip-rule="evenodd"></path>
    </svg>
    <h2 class="text-lg font-semibold text-gray-800">Payment Tracking & Progress</h2>
  </div>

  <!-- Top Stats -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-600">Total Due</span>
        <x-icon name="dollar-sign" class="w-5 h-5 mr-2 text-blue-600"></x-icon>
      </div>
      <p class="text-lg font-semibold text-gray-800">Rp @rupiah($invoice->payment_vat)</p>
    </div>
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-600">Total Paid</span>
        <x-icon name="circle-check-big" class="w-5 h-5 mr-2 text-green-600"></x-icon>
      </div>
      <p class="text-lg font-semibold text-green-600">Rp @rupiah($invoice->paid_amount)</p>
    </div>
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-600">Remaining</span>
        <x-icon name="clock" class="w-5 h-5 mr-2 text-yellow-600"></x-icon>
      </div>
      <p class="text-lg font-semibold text-gray-800">Rp @rupiah($unpaid)</p>
    </div>
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-600">Progress</span>
        <x-icon name="circle-dashed" class="w-5 h-5 mr-2 text-purple-600"></x-icon>
      </div>
      <p class="text-lg font-semibold text-purple-600">{{ $progress }}%</p>
    </div>
  </div>

  @php
    // hitung progress jika pakai paid_amount vs payment_vat
    $progress = $invoice->payment_vat > 0 ? round(($invoice->paid_amount / $invoice->payment_vat) * 100) : 0;

    // batasin progress max 100
    $progress = min($progress, 100);
  @endphp

  <!-- Progress Bar -->
  <div class="mb-6">
    <div class="flex justify-between text-sm text-gray-600 mb-1">
      <span>Payment Progress</span>
      <span class="font-medium text-green-700">{{ $progress }}% Complete</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2">
      <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
    </div>
    <div class="flex justify-between text-xs text-gray-500 mt-1">
      <span>0%</span><span>25%</span><span>50%</span><span>75%</span><span>100%</span>
    </div>
  </div>


  <!-- Payment History -->
  <div>
    <h3 class="text-md font-semibold text-gray-800 mb-3">Payment History</h3>
    <div class="overflow-x-auto">
      <table class="w-full border border-gray-200 rounded-lg text-left text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2">DATE</th>
            <th class="px-4 py-2">AMOUNT</th>
            <th class="px-4 py-2">METHOD</th>
            <th class="px-4 py-2">REFERENCE</th>
            <th class="px-4 py-2">DESCRIPTION</th>
          </tr>
        </thead>
        <tbody>
          @forelse($invoice->payments as $payment)
            <tr class="bg-white border-t">
              <td class="px-4 py-2">
                {{ optional($payment->created_at)->format('d F Y H:i:s') ?? ($payment->date ?? '-') }}
              </td>
              <td class="px-4 py-2 font-semibold text-green-600">
                Rp @rupiah($payment->amount ?? ($payment->paid_amount ?? 0))
              </td>
              <td class="px-4 py-2">{{ $payment->method ?? ($payment->pay_method ?? '-') }}</td>
              <td class="px-4 py-2">{{ $payment->reference ?? ($payment->transaction_id ?? '-') }}</td>
              </td>
              <td class="px-4 py-2">{{ $payment->description ?? ($payment->note ?? '-') }}</td>
            </tr>
          @empty
            <tr class="bg-white border-t">
              <td class="px-4 py-6 text-center text-gray-500" colspan="6">No payment history found for this invoice.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
