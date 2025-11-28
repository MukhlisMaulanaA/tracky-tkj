@extends('layouts.dashboard')

@section('title', 'Detail Purchase Order')

@section('content')
  <div class="max-w-4xl mx-auto py-8">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Detail Purchase Order</h1>
      <a href="{{ route('purchase_orders.index') }}" class="text-sm text-gray-600">Kembali</a>
    </header>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <dl class="grid grid-cols-1 gap-4">
        <div>
          <dt class="text-sm text-gray-600">ID PO</dt>
          <dd class="font-medium">{{ $purchaseOrder->id_po }}</dd>
        </div>

        <div>
          <dt class="text-sm text-gray-600">Nomor PO</dt>
          <dd class="font-medium">{{ $purchaseOrder->po_number }}</dd>
        </div>

        <div>
          <dt class="text-sm text-gray-600">Project</dt>
          <dd class="font-medium">{{ $purchaseOrder->project->id_project ?? '-' }} - {{ $purchaseOrder->project->project_name ?? '-' }}</dd>
        </div>

        <div>
          <dt class="text-sm text-gray-600">Tanggal Dibuat</dt>
          <dd class="font-medium">{{ \Illuminate\Support\Carbon::parse($purchaseOrder->created_date)->format('d M Y') }}</dd>
        </div>

        <div>
          <dt class="text-sm text-gray-600">Total Value</dt>
          <dd class="font-medium">{{ $purchaseOrder->total_value ? 'Rp' . number_format($purchaseOrder->total_value, 0, ',', '.') : '-' }}</dd>
        </div>

        <div>
          <dt class="text-sm text-gray-600">Status</dt>
          <dd class="font-medium">{{ $purchaseOrder->status }}</dd>
        </div>

        <div>
          <dt class="text-sm text-gray-600">Dokumen</dt>
          <dd class="font-medium">
            @if($purchaseOrder->document)
              <a href="{{ asset('storage/' . $purchaseOrder->document) }}" target="_blank" class="text-blue-600">Unduh / Lihat Dokumen</a>
            @else
              -
            @endif
          </dd>
        </div>

        <div>
          <dt class="text-sm text-gray-600">Catatan</dt>
          <dd class="font-medium">{{ $purchaseOrder->note ?? '-' }}</dd>
        </div>
      </dl>

      @if($purchaseOrder->items && $purchaseOrder->items->count())
        <hr class="my-6">
        <h3 class="text-lg font-medium mb-3">Items</h3>
        <table class="w-full table-auto">
          <thead>
            <tr class="text-left text-sm text-gray-600 border-b">
              <th class="py-2">Deskripsi</th>
              <th class="py-2">Qty</th>
              <th class="py-2">Unit</th>
              <th class="py-2">Unit Price</th>
              <th class="py-2">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($purchaseOrder->items as $item)
              <tr class="border-b">
                <td class="py-2">{{ $item->description }}</td>
                <td class="py-2">{{ $item->quantity }}</td>
                <td class="py-2">{{ $item->unit }}</td>
                <td class="py-2">{{ $item->unit_price ? 'Rp' . number_format($item->unit_price, 0, ',', '.') : '-' }}</td>
                <td class="py-2">{{ $item->subtotal ? 'Rp' . number_format($item->subtotal, 0, ',', '.') : '-' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection
