@extends('layouts.dashboard')

@section('content')
  <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Payment untuk Invoice {{ $invoice->invoice_number }}</h2>

    <form action="{{ route('payments.store', $invoice->id) }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
        <input type="number" step="0.01" name="amount" required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
        <input type="date" name="payment_date" required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
        <input type="text" name="pay_method"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Nomor Referensi</label>
        <input type="text" name="reference"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Catatan</label>
        <textarea name="notes" rows="3"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
          Simpan Payment
        </button>
      </div>
    </form>
  </div>
@endsection
