@extends('layouts.dashboard')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Project Tracker</h1>
        <p class="mt-2 text-gray-600">Manage and track all your projects in one place</p>
      </div>
      <div class="mt-4 sm:mt-0 flex space-x-3">
        <a href="{{ route('projects.create') }}"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
          <x-icon name="plus" class="h-4 w-4 mr-2" />
          Add Project
        </a>
      </div>
    </div>

    <div class="mb-4">
      <label class="text-sm font-medium text-gray-700 mr-2">Filter Status:</label>
      <select id="filter-remark" class="border border-gray-300 rounded px-3 py-1 text-sm">
        <option value="">All</option>
        <option value="Approved">Approved</option>
        <option value="On Progress">On Progress</option>
        <option value="Pending">Pending</option>
        <option value="Cancel">Cancel</option>
      </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <table id="project-table" class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th class="px-4 py-2">No</th>
            <th class="px-4 py-2">ID Project</th>
            <th class="px-4 py-2">Project Name</th>
            <th class="px-4 py-2">Customer Name</th>
            <th class="px-4 py-2">Location</th>
            <th class="px-4 py-2">Remarks</th>
            <th class="px-4 py-2">Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      const table = $('#project-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('projects.datatable') }}',
          data: function(d) {
            d.remark_filter = $('#filter-remark').val();
          }
        },
        columns: [{
            data: null,
            orderable: false,
            searchable: false
          },
          {
            data: 'id_project'
          },
          {
            data: 'project_name'
          },
          {
            data: 'customer_name'
          },
          {
            data: 'location'
          },
          {
            data: 'remarks',
            render: function(data, type, row) {
              let color = 'bg-gray-100 text-gray-800';
              if (data === 'Approved') color = 'bg-blue-100 text-blue-800';
              else if (data === 'On Progress') color = 'bg-green-100 text-green-800';
              else if (data === 'Pending') color = 'bg-yellow-100 text-yellow-800';
              else if (data === 'Cancel') color = 'bg-red-100 text-red-800';
              return `<span class="px-3 py-1 rounded-full text-sm font-medium ${color}">${data}</span>`;
            }
          },
          {
            data: 'action',
            orderable: false,
            searchable: false
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
