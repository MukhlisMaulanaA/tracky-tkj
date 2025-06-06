@extends('layouts.dashboard')

@section('content')
  <div class="space-y-8">
    <!-- Page Header -->
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
      <p class="mt-2 text-gray-600">Welcome back! Here's what's happening with your business today.</p>
    </div>

    <!-- Stats Cards -->
    @php
      $stats = [
          [
              'name' => 'Total Revenue',
              'value' => '$45,231.89',
              'change' => '+20.1%',
              'changeType' => 'positive',
              'icon' => 'dollar-sign',
          ],
          [
              'name' => 'Pending Invoices',
              'value' => '12',
              'change' => '-4.3%',
              'changeType' => 'negative',
              'icon' => 'file-text',
          ],
          [
              'name' => 'Active Employees',
              'value' => '24',
              'change' => '+12.5%',
              'changeType' => 'positive',
              'icon' => 'users',
          ],
          [
              'name' => 'Monthly Growth',
              'value' => '8.2%',
              'change' => '+2.4%',
              'changeType' => 'positive',
              'icon' => 'trending-up',
          ],
      ];
    @endphp

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ($stats as $stat)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">{{ $stat['name'] }}</p>
              <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stat['value'] }}</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg">
              <x-icon :name="$stat['icon']" class="h-6 w-6 text-blue-600" />
            </div>
          </div>
          <div class="mt-4 flex items-center">
            <x-icon :name="$stat['changeType'] === 'positive' ? 'trending-up' : 'trending-down'"
              class="h-4 w-4 mr-1 {{ $stat['changeType'] === 'positive' ? 'text-green-500' : 'text-red-500' }}" />
            <span
              class="text-sm font-medium {{ $stat['changeType'] === 'positive' ? 'text-green-600' : 'text-red-600' }}">
              {{ $stat['change'] }}
            </span>
            <span class="text-sm text-gray-500 ml-1">from last month</span>
          </div>
        </div>
      @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Recent Invoices -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Recent Invoices</h3>
          <x-icon name="file-text" class="h-5 w-5 text-gray-400" />
        </div>
        <div class="divide-y divide-gray-200">
          @foreach ([['id' => 'INV-001', 'client' => 'Acme Corp', 'amount' => '$2,500.00', 'status' => 'paid', 'date' => '2024-01-15'], ['id' => 'INV-002', 'client' => 'Tech Solutions', 'amount' => '$1,800.00', 'status' => 'pending', 'date' => '2024-01-14'], ['id' => 'INV-003', 'client' => 'Design Studio', 'amount' => '$3,200.00', 'status' => 'overdue', 'date' => '2024-01-10'], ['id' => 'INV-004', 'client' => 'Marketing Plus', 'amount' => '$950.00', 'status' => 'paid', 'date' => '2024-01-12']] as $invoice)
            @php
              $statusClass = match ($invoice['status']) {
                  'paid' => 'bg-green-100 text-green-800',
                  'pending' => 'bg-yellow-100 text-yellow-800',
                  'overdue' => 'bg-red-100 text-red-800',
                  default => 'bg-gray-100 text-gray-800',
              };
            @endphp
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-900">{{ $invoice['id'] }}</p>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                      {{ $invoice['status'] }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-600 mt-1">{{ $invoice['client'] }}</p>
                  <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-semibold text-gray-900">{{ $invoice['amount'] }}</span>
                    <span class="text-xs text-gray-500 flex items-center">
                      <x-icon name="calendar" class="h-3 w-3 mr-1" />
                      {{ $invoice['date'] }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Recent Payrolls -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Recent Payrolls</h3>
          <x-icon name="dollar-sign" class="h-5 w-5 text-gray-400" />
        </div>
        <div class="divide-y divide-gray-200">
          @foreach ([['employee' => 'Sarah Johnson', 'position' => 'Senior Developer', 'amount' => '$8,500.00', 'date' => '2024-01-01'], ['employee' => 'Mike Chen', 'position' => 'Project Manager', 'amount' => '$7,200.00', 'date' => '2024-01-01'], ['employee' => 'Emily Davis', 'position' => 'UI/UX Designer', 'amount' => '$6,800.00', 'date' => '2024-01-01'], ['employee' => 'Alex Rodriguez', 'position' => 'Marketing Specialist', 'amount' => '$5,500.00', 'date' => '2024-01-01']] as $payroll)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-900">{{ $payroll['employee'] }}</p>
                  <p class="text-sm text-gray-600 mt-1">{{ $payroll['position'] }}</p>
                  <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-semibold text-green-600">{{ $payroll['amount'] }}</span>
                    <span class="text-xs text-gray-500 flex items-center">
                      <x-icon name="clock" class="h-3 w-3 mr-1" />
                      {{ $payroll['date'] }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['icon' => 'file-text', 'label' => 'Create Invoice', 'hover' => 'blue'], ['icon' => 'dollar-sign', 'label' => 'Process Payroll', 'hover' => 'green'], ['icon' => 'bar-chart-3', 'label' => 'View Reports', 'hover' => 'purple'], ['icon' => 'users', 'label' => 'Manage Staff', 'hover' => 'orange']] as $action)
          <button
            class="flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-{{ $action['hover'] }}-500 hover:bg-{{ $action['hover'] }}-50 transition-colors group">
            <div class="text-center">
              <x-icon :name="$action['icon']"
                class="h-8 w-8 text-gray-400 group-hover:text-{{ $action['hover'] }}-500 mx-auto mb-2" />
              <span
                class="text-sm font-medium text-gray-600 group-hover:text-{{ $action['hover'] }}-600">{{ $action['label'] }}</span>
            </div>
          </button>
        @endforeach
      </div>
    </div>
  </div>
@endsection
