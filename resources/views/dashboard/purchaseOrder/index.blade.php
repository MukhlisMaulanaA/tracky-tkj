@extends('layouts.dashboard')

@section('title', 'Daftar Purchase Orders')

@section('content')
  <div class="max-w-6xl mx-auto py-8">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Daftar Purchase Orders</h1>
      <a href="{{ route('purchase_orders.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Buat PO Baru</a>
    </header>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
      @endif

      <table class="w-full table-auto">
        <thead>
          <tr class="text-left text-sm text-gray-600 border-b">
            <th class="py-2">ID PO</th>
            <th class="py-2">Nomor PO</th>
            <th class="py-2">Project</th>
            <th class="py-2">Tanggal</th>
            <th class="py-2">Total</th>
            <th class="py-2">Dokumen</th>
            <th class="py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($purchaseOrders as $po)
            <tr class="border-b">
              <td class="py-3">{{ $po->id_po }}</td>
              <td class="py-3">{{ $po->po_number }}</td>
              <td class="py-3">{{ $po->project->id_project ?? '-' }} - {{ $po->project->project_name ?? '-' }}</td>
              <td class="py-3">{{ 
                \Illuminate\Support\Carbon::parse($po->created_date)->format('d M Y')
              }}</td>
              <td class="py-3">{{ $po->total_value ? 'Rp' . number_format($po->total_value, 0, ',', '.') : '-' }}</td>
              <td class="py-3">
                @if($po->document)
                  <a href="{{ asset('storage/' . $po->document) }}" target="_blank" class="text-blue-600">Lihat</a>
                @else
                  -
                @endif
              </td>
              <td class="py-3">
                <a href="{{ route('purchase_orders.show', $po->id_po) }}" class="text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded">Lihat</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-6 text-center text-gray-500">Belum ada purchase order</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
