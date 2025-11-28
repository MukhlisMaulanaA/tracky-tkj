@extends('layouts.dashboard')

@section('title', 'Purchase Orders')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Purchase Orders</h1>
        <a href="{{ route('purchase-orders.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Buat PO Baru</a>
    </div>
    <div class="bg-white shadow rounded p-4">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">No. PO</th>
                    <th class="px-4 py-2">Project</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data PO --}}
                @forelse($purchaseOrders as $po)
                <tr>
                    <td class="border px-4 py-2">{{ $po->po_number }}</td>
                    <td class="border px-4 py-2">{{ $po->project->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $po->created_date }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($po->total_value, 2, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $po->status }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('purchase-orders.show', $po->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('purchase-orders.edit', $po->id) }}" class="text-yellow-600 hover:underline ml-2">Edit</a>
                        <form action="{{ route('purchase-orders.destroy', $po->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Hapus PO ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Belum ada Purchase Order.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $purchaseOrders->links() }}
        </div>
    </div>
</div>
@endsection
