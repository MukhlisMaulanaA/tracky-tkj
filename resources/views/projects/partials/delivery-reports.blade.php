<div class="bg-white rounded-lg shadow p-6">
  <h2 class="text-lg font-semibold text-gray-900 mb-4">Berita Acara Serah Terima</h2>
  <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left">Tanggal</th>
        <th class="px-4 py-2 text-left">Deskripsi</th>
        <th class="px-4 py-2 text-left">Status</th>
      </tr>
    </thead>
    <tbody>
      {{-- @forelse ($deliveryReports as $report) --}}
        <tr class="border-t">
          <td class="px-4 py-2">17 Agustus 2025</td>
          <td class="px-4 py-2">Lorem Ipsum Dolor Sit Amet</td>
          <td class="px-4 py-2">Done</td>
        </tr>
      {{-- @empty --}}
        <tr>
          <td colspan="3" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
        </tr>
      {{-- @endforelse --}}
    </tbody>
  </table>
</div>
