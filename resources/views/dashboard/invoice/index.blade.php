@extends('layouts.dashboard')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Invoice Tracker</h1>
        <p class="mt-2 text-gray-600">Manage and track all your invoices in one place</p>
      </div>
      <div class="mt-4 sm:mt-0 flex space-x-3">
        <button
          class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
          <x-icon name="download" class="h-4 w-4 mr-2" />
          Export PDF
        </button>
        <button
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
          <x-icon name="plus" class="h-4 w-4 mr-2" />
          New Invoice
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <x-invoice.stat-card title="Total Amount" value="$15,750.00" color="blue" />
      <x-invoice.stat-card title="Paid Amount" value="$3,450.00" color="green" />
      <x-invoice.stat-card title="Pending Amount" value="$7,250.00" color="yellow" />
    </div>

    <div class="mb-4">
      <label class="text-sm font-medium text-gray-700 mr-2">Filter Status:</label>
      <select id="filter-remark" class="border border-gray-300 rounded px-3 py-1 text-sm">
        <option value="">All</option>
        <option value="DONE">Done Payment</option>
        <option value="PROCES">Process Payment</option>
        <option value="WAITING">Waiting Payment</option>
      </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table id="invoice-table" class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th>No.</th>
              <th>ID Project</th>
              <th>Project</th>
              <th>Customer</th>
              <th class="px-4 py-2 w-44">Date Details</th>
              <th>PO Number</th>
              <th>Invoice Number</th>
              <th class="px-4 py-2 w-24">Amount</th>
              <th class="px-4 py-2 w-24">PPN</th>
              <th class="px-4 py-2 w-24">PPH</th>
              <th class="px-4 py-2 w-24">Denda</th>
              <th class="px-4 py-2 w-28">Payment VAT</th>
              <th class="px-4 py-2 w-28">Real Payment</th>
              <th>Remark</th>
            </tr>
          </thead>
        </table>

      </div>
    </div>
  </div>
  @push('scripts')
    <script>
      $(document).ready(function() {
        const table = $('#invoice-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: '{{ route('invoices.datatable') }}',
            data: function(d) {
              d.remark_filter = $('#filter-remark').val();
            }
          },
          columns: [{
              data: null,
              name: 'no',
              orderable: false,
              searchable: false
            },
            {
              data: 'id_project'
            },
            {
              data: 'project_name',
            },
            {
              data: 'customer_name'
            },
            {
              data: 'date_details',
              name: 'date_details'
            },

            {
              data: 'po_number'
            },
            {
              data: 'invoice_number'
            },
            {
              data: 'amount'
            },
            {
              data: 'vat_11'
            },
            {
              data: 'pph_2'
            },
            {
              data: 'denda'
            },
            {
              data: 'payment_vat'
            },
            {
              data: 'real_payment'
            },
            {
              data: 'remark'
            },
          ],
          columnDefs: [{
            targets: 0,
            render: function(data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          }],
          createdRow: function(row, data, dataIndex) {
            $(row).addClass('text-sm');
          },
        });
        $('#filter-remark').change(function() {
          table.ajax.reload();
        });
      });
    </script>
  @endpush
  @push('styles')
    <style>
      table#invoice-table th,
      table#invoice-table td {
        vertical-align: top;
        /* white-space: normal !important; */
      }

      table#invoice-table td {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
      }
    </style>
  @endpush
@endsection
