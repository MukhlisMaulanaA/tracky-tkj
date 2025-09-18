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
              <td class="px-4 py-2">
                @if(!empty($payment->proof_image))
                  <button type="button" class="view-proof-btn text-blue-600 hover:underline" data-proof="{{ asset('storage/' . $payment->proof_image) }}" aria-label="View proof for {{ $payment->id_payment ?? 'payment' }}">View Proof</button>
                @elseif(!empty($payment->reference) || !empty($payment->transaction_id))
                  {{ $payment->reference ?? $payment->transaction_id }}
                @else
                  <span class="text-gray-500">-</span>
                @endif
              </td>
              <td class="px-4 py-2">{{ $payment->description ?? ($payment->notes ?? '-') }}</td>
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

    <!-- Proof modal -->
    <div id="proof-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60">
      <div class="relative max-w-3xl w-full mx-4">
        <button id="proof-modal-close" class="absolute right-0 top-0 mt-2 mr-2 text-white bg-gray-800 bg-opacity-60 hover:bg-opacity-80 rounded-full w-8 h-8 flex items-center justify-center" aria-label="Close image modal">×</button>
        <div class="bg-white rounded shadow-lg overflow-hidden">
          <img id="proof-modal-img" src="" alt="Proof image" class="w-full h-auto object-contain max-h-[80vh] bg-black">
        </div>
      </div>
    </div>

    @push('scripts')
      <script>
        (function() {
          function initProofModal() {
            const modal = document.getElementById('proof-modal');
            const modalImg = document.getElementById('proof-modal-img');
            const closeBtn = document.getElementById('proof-modal-close');
            if (!modal || !modalImg || !closeBtn) return;

            // open handlers
            document.querySelectorAll('.view-proof-btn').forEach(function(btn) {
              btn.addEventListener('click', function(e) {
                const url = btn.getAttribute('data-proof');
                if (!url) return;
                modalImg.src = url;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                // focus close for accessibility
                closeBtn.focus();
              });
            });

            function closeModal() {
              modal.classList.add('hidden');
              modal.classList.remove('flex');
              modalImg.src = '';
            }

            closeBtn.addEventListener('click', closeModal);

            // click outside to close
            modal.addEventListener('click', function(e) {
              if (e.target === modal) closeModal();
            });

            // close on Escape
            document.addEventListener('keydown', function(e) {
              if (e.key === 'Escape' || e.key === 'Esc') {
                if (!modal.classList.contains('hidden')) closeModal();
              }
            });
          }

          if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initProofModal);
          } else {
            initProofModal();
          }
        })();
      </script>
    @endpush
</div>
</div>
