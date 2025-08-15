@extends('layouts.dashboard')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">

      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Invoice Baru</h1>
        <p class="text-sm text-gray-600">Lengkapi informasi berikut untuk membuat invoice</p>
      </div>

      <form method="POST" action="{{ route('invoices.store') }}" class="space-y-8">
        @csrf

        <!-- Main Form Container -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">

          <!-- Project Selection -->
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Project</h3>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">ID Project</label>
              <select id="id_project" name="id_project"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required>
                <option value="">-- Pilih Project --</option>
                @foreach ($projects as $project)
                  <option value="{{ $project->id_project }}">{{ $project->id_project }} - {{ $project->project_name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Include all form fields same as create -->
          @include('invoice.partials.form-fields', ['invoice' => $invoice])
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-end">
          <button type="button" onclick="history.back()"
            class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-medium transition-colors">
            Batal
          </button>
          <button type="submit"
            class="px-6 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium transition-colors">
            Simpan Invoice
          </button>
        </div>
      </form>
    </div>
  </div>

  @push('styles')
    <style>
      /* Select2 Styling */
      .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 6px !important;
        padding-left: 8px !important;
      }

      .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
        padding-left: 4px !important;
        color: #374151 !important;
      }

      .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 8px !important;
      }

      .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
      }

      /* Loading Animation */
      .loading-pulse {
        animation: pulse 1.5s ease-in-out infinite;
      }

      @keyframes pulse {

        0%,
        100% {
          opacity: 1;
        }

        50% {
          opacity: 0.5;
        }
      }

      /* Form Focus States */
      input:focus,
      textarea:focus,
      select:focus {
        outline: none;
      }

      /* Required Field Indicator */
      .required-field {
        position: relative;
      }

      .required-field::after {
        content: "*";
        color: #ef4444;
        margin-left: 2px;
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('#id_project').select2({
          ajax: {
            url: '{{ route('projects.select2') }}',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
              return {
                results: data
              };
            }
          },
          placeholder: '-- Pilih Project --',
          minimumInputLength: 0, // langsung muncul tanpa search
          width: '100%'
        });

        // Buka dropdown langsung fetch data
        $('#id_project').one('focus', function() {
          $(this).select2('open');
        });

        // Project selection handler
        $('#id_project').on('change', function() {
          const projectId = $(this).val();

          // Clear all fields
          const fieldIds = ['customer_name', 'project_name', 'year', 'po_number'];
          fieldIds.forEach(id => {
            document.getElementById(id).value = '';
          });

          if (!projectId) return;

          // Show loading state
          fieldIds.forEach(id => {
            const field = document.getElementById(id);
            field.value = 'Loading...';
            field.classList.add('loading-pulse');
          });

          // Fetch project details
          fetch(`/projects/${projectId}/detail`)
            .then(response => {
              if (!response.ok) throw new Error('Network response was not ok');
              return response.json();
            })
            .then(data => {
              document.getElementById('customer_name').value = data.customer_name || '';
              document.getElementById('project_name').value = data.project_name || '';
              document.getElementById('year').value = data.year || '';
              document.getElementById('po_number').value = data.nomor_po || '';
            })
            .catch(error => {
              console.error('Error fetching project details:', error);
              alert('Gagal memuat detail project. Silakan coba lagi.');
              fieldIds.forEach(id => {
                document.getElementById(id).value = '';
              });
            })
            .finally(() => {
              // Remove loading state
              fieldIds.forEach(id => {
                document.getElementById(id).classList.remove('loading-pulse');
              });
            });
        });

        // Auto-calculate VAT and PPH
        const amountField = document.querySelector('input[name="amount"]');
        const vatField = document.querySelector('input[name="vat"]');
        const pphField = document.querySelector('input[name="pph"]');

        if (amountField) {
          amountField.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;

            // Auto-calculate VAT 11% if empty
            if (vatField && !vatField.value) {
              vatField.value = (amount * 0.11).toFixed(2);
            }

            // Auto-calculate PPH 2% if empty
            if (pphField && !pphField.value) {
              pphField.value = (amount * 0.02).toFixed(2);
            }
          });
        }

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
          const requiredFields = form.querySelectorAll('[required]');
          let isValid = true;

          requiredFields.forEach(field => {
            if (!field.value.trim()) {
              field.classList.add('border-red-500');
              isValid = false;
            } else {
              field.classList.remove('border-red-500');
            }
          });

          if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
          }
        });
      });

      function formatRupiah(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      function parseNumber(val) {
        return parseFloat(val.replace(/,/g, '')) || 0;
      }

      function hitungOtomatis() {
        const amount = parseNumber(document.querySelector('[name="amount"]').value);
        const vatPercent = parseNumber(document.querySelector('[name="vat_percent"]').value)
        const pphPercent = parseNumber(document.querySelector('[name="pph_percent"]').value);
        const denda = parseNumber(document.querySelector('[name="denda"]').value);

        const vat = Math.round(amount * (vatPercent / 100));
        const pph = Math.round(amount * (pphPercent / 100));
        const paymentVat = amount + vat;
        const realPayment = amount - pph - (denda || 0);

        document.querySelector('[name="amount"]').value = formatRupiah(amount);
        document.querySelector('[name="denda"]').value = formatRupiah(denda);
        document.querySelector('[name="vat"]').value = formatRupiah(vat);
        document.querySelector('[name="pph"]').value = formatRupiah(pph);
        document.querySelector('[name="payment_vat"]').value = formatRupiah(paymentVat);
        document.querySelector('[name="real_payment"]').value = formatRupiah(realPayment);
      }

      document.addEventListener('DOMContentLoaded', function() {
        const elements = ['amount', 'pph_percent', 'denda'];
        elements.forEach(id => {
          const input = document.querySelector(`[name="${id}"]`);
          input.addEventListener('input', hitungOtomatis);
        });

        // Tambahkan event untuk tombol hitung otomatis
        const btnHitung = document.getElementById('btn-hitung-otomatis');
        if (btnHitung) {
          btnHitung.addEventListener('click', hitungOtomatis);
        }
      });

      // interactive buttone
      document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.remark-button');

        buttons.forEach(button => {
          button.addEventListener('click', () => {
            // Reset semua ke default (abu)
            buttons.forEach(btn => {
              btn.classList.remove('bg-green-100', 'text-green-800', 'border-green-300');
              btn.classList.remove('bg-yellow-100', 'text-yellow-800', 'border-yellow-300');
              btn.classList.remove('bg-red-100', 'text-red-800', 'border-red-300');
              btn.classList.add('bg-gray-100', 'text-gray-700', 'border-gray-300');
            });

            // Tandai sebagai terpilih
            const val = button.getAttribute('data-value');
            button.previousElementSibling.checked = true;

            if (val === 'DONE PAYMENT') {
              button.classList.remove('bg-gray-100', 'text-gray-700', 'border-gray-300');
              button.classList.add('bg-green-100', 'text-green-800', 'border-green-300');
            } else if (val === 'PROCES PAYMENT') {
              button.classList.remove('bg-gray-100', 'text-gray-700', 'border-gray-300');
              button.classList.add('bg-yellow-100', 'text-yellow-800', 'border-yellow-300');
            } else if (val === 'WAITING PAYMENT') {
              button.classList.remove('bg-gray-100', 'text-gray-700', 'border-gray-300');
              button.classList.add('bg-red-100', 'text-red-800', 'border-red-300');
            }
          });
        });

        // Trigger default button
        document.querySelector('.remark-button[data-value="DONE PAYMENT"]').click();
      });
    </script>
  @endpush
@endsection
