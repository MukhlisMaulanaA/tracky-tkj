@extends('layouts.dashboard')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Salary Tracker</h1>
        <p class="mt-2 text-gray-600">Manage employee salaries and payroll processing</p>
      </div>
      <div class="mt-4 sm:mt-0 flex space-x-3">
        <button
          class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
          <x-icon name="download" class="h-4 w-4 mr-2" />
          Export Payroll
        </button>
        <button
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
          <x-icon name="plus" class="h-4 w-4 mr-2" />
          Add Employee
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <x-invoice.stat-card title="Total Payroll" value="$39,800.00" color="blue" />
      <x-invoice.stat-card title="Paid Amount" value="$20,960.00" color="green" />
      <x-invoice.stat-card title="Pending Amount" value="$13,740.00" color="yellow" />
      <x-invoice.stat-card title="Total Employees" value="6" color="purple" icon="users" />
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
          <div class="relative">
            <x-icon name="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
            <input type="text" placeholder="Search employees..."
              class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm" />
          </div>
          <div class="flex items-center space-x-2">
            <x-icon name="filter" class="h-4 w-4 text-gray-400" />
            <select class="border border-gray-300 rounded-lg text-sm px-3 py-2 capitalize">
              <option>All Departments</option>
              <option>Engineering</option>
              <option>Management</option>
              <option>Design</option>
              <option>Marketing</option>
              <option>Analytics</option>
            </select>
          </div>
        </div>
        <div class="text-sm text-gray-600">
          Showing 6 of 6 employees
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              @foreach (['Employee', 'Position', 'Base Salary', 'Bonus', 'Deductions', 'Net Salary', 'Status', 'Actions'] as $col)
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  {{ $col }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ([
          ['id' => 'EMP-001', 'name' => 'Sarah Johnson', 'position' => 'Senior Developer', 'dept' => 'Engineering', 'base' => 8500, 'bonus' => 500, 'deduct' => 850, 'net' => 8150, 'status' => 'paid'],
          ['id' => 'EMP-002', 'name' => 'Mike Chen', 'position' => 'Project Manager', 'dept' => 'Management', 'base' => 7200, 'bonus' => 300, 'deduct' => 720, 'net' => 6780, 'status' => 'paid'],
          ['id' => 'EMP-003', 'name' => 'Emily Davis', 'position' => 'UI/UX Designer', 'dept' => 'Design', 'base' => 6800, 'bonus' => 200, 'deduct' => 680, 'net' => 6320, 'status' => 'pending'],
          ['id' => 'EMP-004', 'name' => 'Alex Rodriguez', 'position' => 'Marketing Specialist', 'dept' => 'Marketing', 'base' => 5500, 'bonus' => 150, 'deduct' => 550, 'net' => 5100, 'status' => 'processing'],
          ['id' => 'EMP-005', 'name' => 'Lisa Wang', 'position' => 'Data Analyst', 'dept' => 'Analytics', 'base' => 6200, 'bonus' => 250, 'deduct' => 620, 'net' => 5830, 'status' => 'paid'],
          ['id' => 'EMP-006', 'name' => 'David Brown', 'position' => 'DevOps Engineer', 'dept' => 'Engineering', 'base' => 7800, 'bonus' => 400, 'deduct' => 780, 'net' => 7420, 'status' => 'pending'],
      ] as $e)
              @php
                $statusColor = match ($e['status']) {
                    'paid' => 'bg-green-100 text-green-800 border-green-200',
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                    default => 'bg-gray-100 text-gray-800 border-gray-200',
                };
              @endphp
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap flex items-center">
                  <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                    <x-icon name="user" class="h-5 w-5 text-white" />
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ $e['name'] }}</div>
                    <div class="text-sm text-gray-500">{{ $e['id'] }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ $e['position'] }}</div>
                  <div class="text-sm text-gray-500">{{ $e['dept'] }}</div>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format($e['base'], 2) }}</td>
                <td class="px-6 py-4 text-sm font-medium text-green-600">+${{ number_format($e['bonus'], 2) }}</td>
                <td class="px-6 py-4 text-sm font-medium text-red-600">-${{ number_format($e['deduct'], 2) }}</td>
                <td class="px-6 py-4 text-sm font-bold text-gray-900">${{ number_format($e['net'], 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColor }}">
                    {{ ucfirst($e['status']) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center space-x-2">
                    <x-icon name="edit" class="h-4 w-4 text-gray-400 hover:text-green-600" />
                    <x-icon name="trash-2" class="h-4 w-4 text-gray-400 hover:text-red-600" />
                    <x-icon name="more-horizontal" class="h-4 w-4 text-gray-400 hover:text-gray-600" />
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Department Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Department Summary</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['name' => 'Engineering', 'count' => 2, 'total' => 15570], ['name' => 'Management', 'count' => 1, 'total' => 6780], ['name' => 'Design', 'count' => 1, 'total' => 6320], ['name' => 'Marketing', 'count' => 1, 'total' => 5100], ['name' => 'Analytics', 'count' => 1, 'total' => 5830]] as $dept)
          <div class="p-4 bg-gray-50 rounded-lg">
            <h4 class="font-medium text-gray-900">{{ $dept['name'] }}</h4>
            <p class="text-sm text-gray-600 mt-1">{{ $dept['count'] }} employees</p>
            <p class="text-lg font-bold text-blue-600 mt-2">${{ number_format($dept['total'], 2) }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
