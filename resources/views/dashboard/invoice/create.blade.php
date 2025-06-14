@extends('layouts.dashboard')

@section('content')
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-5xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
          <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
          </div>
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Invoice Baru</h1>
            <p class="text-gray-600">Lengkapi form di bawah untuk membuat invoice baru</p>
          </div>
        </div>
      </div>

      <form method="POST" action="{{ route('invoice.store') }}" class="space-y-8">
        @csrf

        <!-- Project Selection Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
              </svg>
              Pilih Project
            </h2>
          </div>
          <div class="p-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">ID Project</label>
            <select id="id_project" name="id_project"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
              required>
              <option value="">-- Pilih Project --</option>
              @foreach ($projects as $project)
                <option value="{{ $project->id_project }}">{{ $project->id_project }} - {{ $project->project_name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Project Details Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Detail Project
            </h2>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
              <div class="lg:col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer</label>
                <input type="text" id="customer_name" name="customer_name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                  readonly>
              </div>
              <div class="lg:col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Project</label>
                <input type="text" id="project_name" name="project_name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                  readonly>
              </div>
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <input type="text" id="year" name="year" maxlength="4"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                  readonly>
              </div>
            </div>
          </div>
        </div>

        <!-- Index Details Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                </path>
              </svg>
              Detail Index
            </h2>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor PO</label>
                <input type="text" id="po_number" name="po_number"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                  placeholder="Masukkan nomor PO">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Invoice</label>
                <input type="text" name="invoice_number"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                  placeholder="Masukkan nomor invoice">
              </div>
            </div>
          </div>
        </div>

        <!-- Date Details Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Detail Tanggal
            </h2>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Buat</label>
                <input type="date" name="create_date"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Submit</label>
                <input type="date" name="submit_date"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pembayaran</label>
                <input type="date" name="date_payment"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
              </div>
            </div>
          </div>
        </div>

        <!-- Amount Details Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                </path>
              </svg>
              Detail Jumlah
            </h2>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount *</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                  <input type="number" step="0.01" name="amount" required
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                    placeholder="0.00">
                </div>
              </div>
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2">VAT 11% *</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                  <input type="number" step="0.01" name="vat_11" required
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                    placeholder="0.00">
                </div>
              </div>
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2">PPH 2% *</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                  <input type="number" step="0.01" name="pph_2" required
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                    placeholder="0.00">
                </div>
              </div>
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Denda</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                  <input type="number" step="0.01" name="denda"
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                    placeholder="0.00">
                </div>
              </div>
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment VAT/PPH 11/2</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                  <input type="number" step="0.01" name="payment_vat"
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                    placeholder="0.00">
                </div>
              </div>
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Real Payment</label>
                <div class="relative">
                  <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                  <input type="number" step="0.01" name="real_payment"
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200"
                    placeholder="0.00">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Remark Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
              </svg>
              Catatan
            </h2>
          </div>
          <div class="p-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Remark</label>
            <textarea name="remark" rows="4"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200 resize-none"
              placeholder="Tambahkan catatan atau keterangan tambahan..."></textarea>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-end">
          <button type="button" onclick="history.back()"
            class="px-8 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium transition-all duration-200 flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
              </path>
            </svg>
            Kembali
          </button>
          <button type="submit"
            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Invoice
          </button>
        </div>
      </form>
    </div>
  </div>

  @push('styles')
    <style>
      .group:hover .group-hover\:shadow-md {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      }

      /* Custom scrollbar */
      ::-webkit-scrollbar {
        width: 6px;
      }

      ::-webkit-scrollbar-track {
        background: #f1f5f9;
      }

      ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
      }

      /* Loading animation for select2 */
      .select2-selection {
        border-radius: 0.75rem !important;
        padding: 0.75rem !important;
        border-color: #d1d5db !important;
        min-height: 48px !important;
      }

      .select2-selection:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important;
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Init Select2
        $('#id_project').select2({
          placeholder: '-- Pilih Project --',
          allowClear: true,
          width: '100%',
          dropdownAutoWidth: true
        });

        // Autofill logic
        $('#id_project').on('change', function() {
          const projectId = $(this).val();

          // Reset fields
          ['customer_name', 'project_name', 'year', 'po_number'].forEach(id => {
            document.getElementById(id).value = '';
          });

          if (!projectId) return;

          // Show loading state
          const fields = ['customer_name', 'project_name', 'year', 'po_number'];
          fields.forEach(id => {
            const field = document.getElementById(id);
            field.value = 'Loading...';
            field.classList.add('animate-pulse');
          });

          fetch(`/projects/${projectId}/detail`)
            .then(res => {
              if (!res.ok) throw new Error('Network response was not ok');
              return res.json();
            })
            .then(data => {
              document.getElementById('customer_name').value = data.customer_name || '';
              document.getElementById('project_name').value = data.project_name || '';
              document.getElementById('year').value = data.year || '';
              document.getElementById('po_number').value = data.nomor_po || '';

              // Remove loading state
              fields.forEach(id => {
                document.getElementById(id).classList.remove('animate-pulse');
              });
            })
            .catch(error => {
              console.error('Error:', error);
              fields.forEach(id => {
                const field = document.getElementById(id);
                field.value = '';
                field.classList.remove('animate-pulse');
              });

              // Show error message
              alert('Gagal memuat detail project. Silakan coba lagi.');
            });
        });

        // Auto-calculate functionality (optional enhancement)
        const amountField = document.querySelector('input[name="amount"]');
        const vatField = document.querySelector('input[name="vat_11"]');
        const pphField = document.querySelector('input[name="pph_2"]');

        if (amountField) {
          amountField.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;

            // Auto-calculate VAT 11%
            if (vatField && !vatField.value) {
              vatField.value = (amount * 0.11).toFixed(2);
            }

            // Auto-calculate PPH 2%
            if (pphField && !pphField.value) {
              pphField.value = (amount * 0.02).toFixed(2);
            }
          });
        }
      });
    </script>
  @endpush
@endsection
