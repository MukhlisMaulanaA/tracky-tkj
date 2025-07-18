@extends('layouts.dashboard')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">

      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Invoice Baru</h1>
        <p class="text-sm text-gray-600">Lengkapi informasi berikut untuk membuat invoice</p>
      </div>

      <form method="POST" action="{{ route('invoice.store') }}" class="space-y-8">
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

          <!-- Project Details -->
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Project</h3>
            <x-icon name="date" class="h-5 w-5 flex-shrink-0" />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
              <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer</label>
                <input type="text" id="customer_name" name="customer_name"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md bg-gray-50 text-gray-700 focus:outline-none"
                  readonly>
              </div>
              <div class="col-span-2 col-start-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Project</label>
                <input type="text" id="project_name" name="project_name"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md bg-gray-50 text-gray-700 focus:outline-none"
                  readonly>
              </div>
              <div class="col-start-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <input type="text" id="year" name="year" maxlength="4"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md bg-gray-50 text-gray-700 focus:outline-none"
                  readonly>
              </div>
            </div>
          </div>

          <!-- Index Details -->
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Index</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor PO</label>
                <input type="text" id="po_number" name="po_number"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  placeholder="Masukkan nomor PO">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Invoice</label>
                <input type="text" name="invoice_number"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  placeholder="Masukkan nomor invoice">
              </div>
            </div>
          </div>

          <!-- Date Details -->
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tanggal</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Buat</label>
                <input type="date" name="create_date"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Submit</label>
                <input type="date" name="submit_date"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pembayaran</label>
                <input type="date" name="date_payment"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
              </div>
            </div>
          </div>

          <!-- Tax Settings -->
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tax Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">VAT %</label>
                <select name="vat_percent"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                  <option value="11" selected>11%</option>
                  <option value="12">12%</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">PPH %</label>
                <input type="number" step="0.01" name="pph_percent" value="2"
                  class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  min="0" max="100">
              </div>
            </div>
          </div>

          <!-- Amount Details -->
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Jumlah</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Amount <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                  <input type="text" name="amount" required
                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="0.00">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  VAT <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                  <input type="text" step="0.01" name="vat_11" required
                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="0.00" readonly>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  PPH <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                  <input type="text" step="0.01" name="pph_2" required
                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="0.00" readonly>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Denda</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                  <input type="text" step="0.01" name="denda"
                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="0.00">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment VAT/PPH 11/2</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                  <input type="text" step="0.01" name="payment_vat"
                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="0.00">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Real Payment</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                  <input type="text" step="0.01" name="real_payment"
                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="0.00">
                </div>
              </div>
            </div>
          </div>

          <!-- Remark -->
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Remark</label>
              <textarea name="remark" rows="3"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                placeholder="Tambahkan catatan atau keterangan tambahan..."></textarea>
            </div>
          </div>
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
          placeholder: '-- Pilih Project --',
          allowClear: true,
          width: '100%'
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
        constvatField = document.querySelector('input[name="vat_11"]');
        const pphField = document.querySelector('input[name="pph_2"]');

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
        const pphPercent = parseNumber(document.querySelector('[name="pph_percent"]').value);
        const denda = parseNumber(document.querySelector('[name="denda"]').value);

        const vat = Math.round(amount * 0.11);
        const pph = Math.round(amount * (pphPercent / 100));
        const paymentVat = amount + vat;
        const realPayment = amount - pph - (denda || 0);

        document.querySelector('[name="amount"]').value = formatRupiah(amount);
        document.querySelector('[name="denda"]').value = formatRupiah(denda);
        document.querySelector('[name="vat_11"]').value = formatRupiah(vat);
        document.querySelector('[name="pph_2"]').value = formatRupiah(pph);
        document.querySelector('[name="payment_vat"]').value = formatRupiah(paymentVat);
        document.querySelector('[name="real_payment"]').value = formatRupiah(realPayment);
      }

      document.addEventListener('DOMContentLoaded', function() {
        const elements = ['amount', 'pph_percent', 'denda'];
        elements.forEach(id => {
          const input = document.querySelector(`[name="${id}"]`);
          input.addEventListener('input', hitungOtomatis);
        });
      });
    </script>
  @endpush
@endsection
