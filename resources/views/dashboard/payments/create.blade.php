@extends('layouts.dashboard')

@section('content')
  <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Payment</h2>

    <form action="{{ route('payments.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
      @csrf

      <!-- Select2 Invoice -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Invoice</label>
        <select id="id_invoice" name="id_invoice" class="w-full"></select>
      </div>

      <!-- Detail singkat invoice -->
      <div id="invoice-details" class="hidden p-4 bg-gray-50 rounded border border-gray-200">
        <p><strong>ID Invoice:</strong> <span id="detail-id"></span></p>
        <p><strong>Invoice Number:</strong> <span id="detail-number"></span></p>
        <p><strong>Customer:</strong> <span id="detail-customer"></span></p>
        <p><strong>Tagihan:</strong> Rp. <span id="detail-tagihan"></span></p>
      </div>

      <!-- Form pembayaran -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
        <input type="text" step="0.01" name="amount" data-type="rupiah" required
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
        <input type="datetime-local" name="payment_date" step="1" required
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
        <input type="text" name="pay_method"
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

      <!-- Proof image upload -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Bukti Pembayaran (opsional)</label>
        <input type="file" name="proof_image" accept="image/*"
          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        @error('proof_image')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mt-4 w-full">
        <div class="flex justify-center">
          <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        </div>

        @error('g-recaptcha-response')
          <div class="mt-2 text-sm text-red-600 dark:text-red-400 text-center">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
          Submit Payment
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#id_invoice').select2({
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

      $('#id_invoice').on('change', function() {
        const id_invoice = $(this).val();
        if (!id_invoice) return $('#invoice-details').addClass('hidden');

        fetch(`/payments/invoices/${id_invoice}/detail`)
          .then(res => res.json())
          .then(data => {
            $('#detail-id').text(data.id_invoice);
            $('#detail-number').text(data.invoice_number);
            $('#detail-customer').text(data.customer_name);
            $('#detail-tagihan').text(data.payment_vat); // ini decimal sudah rapih
            $('#invoice-details').removeClass('hidden');
          });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      // format angka: "1234567" -> "1,234,567"
      function formatNumberWithCommas(strDigits) {
        if (!strDigits) return '';
        return strDigits.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      // cari semua input yang butuh format rupiah
      const rupiahInputs = document.querySelectorAll('input[data-type="rupiah"]');

      rupiahInputs.forEach(function(input) {
        // format initial value (jika ada)
        const initialDigits = (input.value || '').toString().replace(/[^\d]/g, '');
        if (initialDigits !== '') {
          input.value = formatNumberWithCommas(initialDigits);
        } else {
          input.value = '';
        }

        // handle typing (preserve caret using count of digits before caret)
        input.addEventListener('input', function(e) {
          const raw = input.value;
          // jumlah digit di kiri kursor (sebelum format)
          const cursorPos = input.selectionStart || 0;
          const digitsBeforeCursor = raw.slice(0, cursorPos).replace(/[^\d]/g, '').length;

          // strip non-digit -> format
          const onlyDigits = raw.replace(/[^\d]/g, '');
          const formatted = formatNumberWithCommas(onlyDigits);

          input.value = formatted;

          // restore caret at posisi berdasarkan jumlah digit di kiri
          let pos = 0;
          let digitsSeen = 0;
          while (pos < formatted.length && digitsSeen < digitsBeforeCursor) {
            if (/\d/.test(formatted[pos])) digitsSeen++;
            pos++;
          }
          // set caret (safely)
          try {
            input.setSelectionRange(pos, pos);
          } catch (err) {
            // ignore if not supported
          }
        });

        // handle paste: accept numbers only
        input.addEventListener('paste', function(e) {
          e.preventDefault();
          const text = (e.clipboardData || window.clipboardData).getData('text') || '';
          const digits = text.replace(/[^\d]/g, '');
          input.value = formatNumberWithCommas(digits);
          // place caret at end
          try {
            input.setSelectionRange(input.value.length, input.value.length);
          } catch (e) {}
        });

        // If inside a form, sanitize before submit (replace non-digits so server receives plain digits)
        const form = input.closest('form');
        if (form) {
          form.addEventListener('submit', function() {
            // replace every rupiah input value with digits-only (no commas)
            form.querySelectorAll('input[data-type="rupiah"]').forEach(function(r) {
              r.value = (r.value || '').toString().replace(/[^\d]/g, '') || '0';
            });
          });
        }
      });
    });
  </script>
@endpush
