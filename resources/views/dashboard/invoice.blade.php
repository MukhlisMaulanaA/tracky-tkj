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

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
          <div class="relative">
            <x-icon name="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
            <input type="text" placeholder="Search invoices..."
              class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm" />
          </div>
          <div class="flex items-center space-x-2">
            <x-icon name="filter" class="h-4 w-4 text-gray-400" />
            <select class="border border-gray-300 rounded-lg text-sm px-3 py-2">
              <option>All Status</option>
              <option>Paid</option>
              <option>Pending</option>
              <option>Overdue</option>
              <option>Draft</option>
            </select>
          </div>
        </div>
        <div class="text-sm text-gray-600">
          Showing 6 of 6 invoices
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              @foreach (['Invoice', 'Client', 'Amount', 'Status', 'Due Date', 'Actions'] as $col)
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  {{ $col }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ([['id' => 'INV-001', 'client' => 'Acme Corporation', 'amount' => 2500, 'status' => 'paid', 'due' => '2024-01-15', 'desc' => 'Web dev'], ['id' => 'INV-002', 'client' => 'Tech Solutions Ltd', 'amount' => 1800, 'status' => 'pending', 'due' => '2024-01-20', 'desc' => 'App design'], ['id' => 'INV-003', 'client' => 'Design Studio Pro', 'amount' => 3200, 'status' => 'overdue', 'due' => '2024-01-10', 'desc' => 'Branding'], ['id' => 'INV-004', 'client' => 'Marketing Plus', 'amount' => 950, 'status' => 'paid', 'due' => '2024-01-12', 'desc' => 'SEO'], ['id' => 'INV-005', 'client' => 'StartUp Hub', 'amount' => 4500, 'status' => 'draft', 'due' => '2024-02-01', 'desc' => 'Full-stack'], ['id' => 'INV-006', 'client' => 'Global Enterprises', 'amount' => 2800, 'status' => 'pending', 'due' => '2024-01-25', 'desc' => 'DB tuning']] as $invoice)
              @php
                $statusColor = match ($invoice['status']) {
                    'paid' => 'bg-green-100 text-green-800 border-green-200',
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'overdue' => 'bg-red-100 text-red-800 border-red-200',
                    'draft' => 'bg-gray-100 text-gray-800 border-gray-200',
                    default => 'bg-gray-100 text-gray-800 border-gray-200',
                };
              @endphp
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap flex items-center">
                  <div class="p-2 bg-blue-50 rounded-lg mr-3">
                    <x-icon name="file-text" class="h-4 w-4 text-blue-600" />
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ $invoice['id'] }}</div>
                    <div class="text-sm text-gray-500">{{ $invoice['desc'] }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $invoice['client'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                  ${{ number_format($invoice['amount'], 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColor }}">
                    {{ ucfirst($invoice['status']) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex items-center">
                  <x-icon name="calendar" class="h-4 w-4 mr-2 text-gray-400" />
                  {{ $invoice['due'] }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center space-x-2">
                    <x-icon name="eye" class="h-4 w-4 text-gray-400 hover:text-blue-600" />
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
  </div>
@endsection
