@extends('layouts.dashboard')

@section('content')
  <div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Buat Invoice Baru</h1>

    <form method="POST" action="{{ route('invoice.store') }}" class="bg-white shadow rounded-lg p-6 space-y-6">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- ID Project -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">ID Project</label>
          <select id="id_project" name="id_project" class="form-select w-full border-gray-300 rounded-md" required>
            <option value="">-- Pilih Project --</option>
            @foreach ($projects as $project)
              <option value="{{ $project->id_project }}">{{ $project->id_project }} - {{ $project->project_name }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Nama Customer -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
          <input type="text" id="customer_name" name="customer_name"
            class="form-input w-full border-gray-300 rounded-md" readonly>
        </div>

        <!-- Nama Project -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Project</label>
          <input type="text" id="project_name" name="project_name" class="form-input w-full border-gray-300 rounded-md"
            readonly>
        </div>

        <!-- Tahun -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
          <input type="text" name="year" maxlength="4" class="form-input w-full border-gray-300 rounded-md"
            required>
        </div>

        <!-- Create Date -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Buat</label>
          <input type="date" name="create_date" class="form-input w-full border-gray-300 rounded-md">
        </div>

        <!-- Submit Date -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Submit</label>
          <input type="date" name="submit_date" class="form-input w-full border-gray-300 rounded-md">
        </div>

        <!-- Date Payment -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
          <input type="date" name="date_payment" class="form-input w-full border-gray-300 rounded-md">
        </div>

        <!-- Nomor PO -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nomor PO</label>
          <input type="text" id="po_number" name="po_number" class="form-input w-full border-gray-300 rounded-md">
        </div>

        <!-- Nomor Invoice -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Invoice</label>
          <input type="text" name="invoice_number" class="form-input w-full border-gray-300 rounded-md">
        </div>

        <!-- Amount -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
          <input type="number" step="0.01" name="amount" class="form-input w-full border-gray-300 rounded-md"
            required>
        </div>

        <!-- Denda -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Denda</label>
          <input type="number" step="0.01" name="denda" class="form-input w-full border-gray-300 rounded-md">
        </div>
      </div>

      <!-- Remark -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Remark</label>
        <textarea name="remark" rows="3" class="form-textarea w-full border-gray-300 rounded-md"></textarea>
      </div>

      <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Init Select2
        $('#id_project').select2({
          placeholder: '-- Pilih Project --',
          allowClear: true,
          width: '100%'
        });

        // Autofill logic
        $('#id_project').on('change', function() {
          const projectId = $(this).val();
          if (!projectId) return;

          fetch(`/projects/${projectId}/detail`)
            .then(res => res.json())
            .then(data => {
              document.getElementById('customer_name').value = data.customer_name;
              document.getElementById('project_name').value = data.project_name;
              document.getElementById('po_number').value = data.nomor_po;
            });
        });
      });
    </script>
  @endpush
@endsection
