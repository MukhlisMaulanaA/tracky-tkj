@extends('layouts.dashboard')

@section('content')
  <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Payment</h2>

    <form action="{{ route('payments.store') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Select2 Invoice -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Invoice</label>
        <select id="invoice_id" name="invoice_id" class="w-full"></select>
      </div>

      <!-- Detail singkat invoice -->
      <div id="invoice-details" class="hidden p-4 bg-gray-50 rounded border border-gray-200">
        <p><strong>ID Invoice:</strong> <span id="detail-id"></span></p>
        <p><strong>Invoice Number:</strong> <span id="detail-number"></span></p>
        <p><strong>Customer:</strong> <span id="detail-customer"></span></p>
      </div>

      <!-- Form pembayaran -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
        <input type="number" step="0.01" name="amount" required
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
        <input type="date" name="payment_date" required
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
        <input type="text" name="method"
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Nomor Referensi</label>
        <input type="text" name="reference"
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Catatan</label>
        <textarea name="notes" rows="3"
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
          Simpan Payment
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#invoice_id').select2({
        ajax: {
          url: '{{ route('payments.invoices.select2') }}',
          dataType: 'json',
          delay: 250,
          data: params => ({
            q: params.term
          }),
          processResults: data => data
        },
        placeholder: '-- Pilih Invoice --',
        minimumInputLength: 0,
        width: '100%'
      });

      $('#invoice_id').on('change', function() {
        const id_invoice = $(this).val();
        if (!id_invoice) return $('#invoice-details').addClass('hidden');

        fetch(`/payments/invoices/${id_invoice}/detail`)
          .then(res => res.json())
          .then(data => {
            $('#detail-id').text(data.id_invoice);
            $('#detail-number').text(data.invoice_number);
            $('#detail-customer').text(data.customer_name);
            $('#invoice-details').removeClass('hidden');
          });
      });
    });
  </script>
@endpush
