<div class="bg-white rounded-lg shadow p-6">
  <h2 class="text-lg font-semibold text-gray-900 mb-4">Pelacakan Kemajuan Sub</h2>
  <ul class="space-y-3">
    {{-- @forelse ($subProgresses as $sub) --}}
      <li class="flex items-center justify-between">
        <div>
          <p class="font-medium">Installation</p>
          <p class="text-sm text-gray-500">21 Agustus 2025</p>
        </div>
        {{-- <span
          class="px-3 py-1 rounded-full text-xs font-medium
                    {{ $sub->status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
          {{ $sub->status }}
        </span> --}}
      </li>
    {{-- @empty --}}
      <li class="text-gray-500">Tidak ada data kemajuan sub</li>
    {{-- @endforelse --}}
  </ul>
</div>
