<div class="bg-white rounded-lg shadow p-6">
  <h2 class="text-lg font-semibold text-gray-900 mb-4">Pesanan Pembelian</h2>
  <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left">No PO</th>
        <th class="px-4 py-2 text-left">Tanggal</th>
        <th class="px-4 py-2 text-left">Jumlah</th>
      </tr>
    </thead>
    <tbody>
      {{-- @forelse ($purchaseOrders as $po) --}}
        <tr class="border-t">
          <td class="px-4 py-2">PO/DT/2025</td>
          <td class="px-4 py-2">20 Agustus 2025</td>
          {{-- <td class="px-4 py-2">Rp{{ number_format($po->amount, 0, ',', '.') }}</td> --}}
          <td class="px-4 py-2">Rp. 85.000.000</td>
        </tr>
      {{-- @empty --}}
        <tr>
          <td colspan="3" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
        </tr>
      {{-- @endforelse --}}
    </tbody>
  </table>
</div>
