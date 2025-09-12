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
      <p class="text-gray-500 text-sm">Total Due</p>
      <p class="text-lg font-semibold text-gray-800">Rp @rupiah($invoice->payment_vat)</p>
    </div>
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <p class="text-gray-500 text-sm">Total Paid</p>
      <p class="text-lg font-semibold text-green-600">Rp 54.880.000</p>
    </div>
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <p class="text-gray-500 text-sm">Remaining</p>
      <p class="text-lg font-semibold text-gray-800">Rp 0</p>
    </div>
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <p class="text-gray-500 text-sm">Progress</p>
      <p class="text-lg font-semibold text-purple-600">{{ $invoice->progress }}%</p>
    </div>
  </div>

  <!-- Progress Bar -->
  <div class="mb-6">
    <div class="flex justify-between text-sm text-gray-600 mb-1">
      <span>Payment Progress</span>
      <span class="font-medium text-green-700">100% Complete</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2">
      <div class="bg-green-600 h-2 rounded-full w-full"></div>
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
            <th class="px-4 py-2">STATUS</th>
            <th class="px-4 py-2">DESCRIPTION</th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white border-t">
            <td class="px-4 py-2">January 17, 2025</td>
            <td class="px-4 py-2 font-semibold text-green-600">Rp 54.880.000</td>
            <td class="px-4 py-2">Bank Transfer</td>
            <td class="px-4 py-2">TXN-2025-001-17</td>
            <td class="px-4 py-2">
              <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Completed</span>
            </td>
            <td class="px-4 py-2">Full payment received</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
