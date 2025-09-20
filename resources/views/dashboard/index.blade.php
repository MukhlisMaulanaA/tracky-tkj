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
              'name' => 'Total Paid Revenue',
              'color' => 'green',
              'value' => $totalPaidIDR,
              'change' => '+20.1%',
              'changeType' => 'positive',
              'icon' => 'dollar-sign',
          ],
          [
              'name' => 'Pending Revenue',
              'color' => 'gray',
              'value' => $unpaidAmountIDR,
              'change' => '-4.3%',
              'changeType' => 'negative',
              'icon' => 'timer',
          ],
          [
              'name' => 'Pending Invoices',
              'color' => 'yellow',
              'value' => $pendingInvoices,
              'change' => '+12.5%',
              'changeType' => 'positive',
              'icon' => 'file-clock',
          ],
          [
              'name' => 'Total Project',
              'color' => 'blue',
              'value' => $totalProject,
              'change' => '+2.4%',
              'changeType' => 'positive',
              'icon' => 'construction',
          ],
      ];
    @endphp

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ($stats as $stat)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">{{ $stat['name'] }}</p>
              <p class="text-2xl font-bold text-{{ $stat['color'] }}-600 mt-2">{{ $stat['value'] }}</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg">
              <x-icon :name="$stat['icon']" class="h-6 w-6 text-blue-600" />
            </div>
          </div>
          {{-- <div class="mt-4 flex items-center">
            <x-icon :name="$stat['changeType'] === 'positive' ? 'trending-up' : 'trending-down'"
              class="h-4 w-4 mr-1 {{ $stat['changeType'] === 'positive' ? 'text-green-500' : 'text-red-500' }}" />
            <span
              class="text-sm font-medium {{ $stat['changeType'] === 'positive' ? 'text-green-600' : 'text-red-600' }}">
              {{ $stat['change'] }}
            </span>
            <span class="text-sm text-gray-500 ml-1">from last month</span>
          </div> --}}
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
          @forelse($recentInvoices as $invoice)
            @php
              $status = strtolower($invoice->remarks ?? $invoice->status ?? 'unknown');
              $statusClass = match ($status) {
                  'done payment' => 'bg-green-100 text-green-800',
                  'done' => 'bg-green-100 text-green-800',
                  'paid' => 'bg-green-100 text-green-800',
                  'proces payment', 'process payment', 'proses payment' => 'bg-yellow-100 text-yellow-800',
                  'waiting payment', 'waitng payment' => 'bg-yellow-100 text-yellow-800',
                  'overdue' => 'bg-red-100 text-red-800',
                  default => 'bg-gray-100 text-gray-800',
              };

              // displayable client name
              $client = $invoice->project->customer_name ?? $invoice->invoice_number ?? ($invoice->id_invoice ?? '—');
              $amount = $invoice->payment_vat ?? $invoice->amount ?? 0;
              $amountFormatted = 'Rp' . number_format($amount, 0, ',', '.');
              $date = $invoice->create_date ?? $invoice->submit_date ?? optional($invoice->created_at)->toDateString();
            @endphp
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-900">{{ $invoice->id_invoice ?? $invoice->invoice_number }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                      {{ $invoice->remarks ?? $invoice->status ?? 'N/A' }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-600 mt-1">{{ $client }}</p>
                  <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-semibold text-gray-900">{{ $amountFormatted }}</span>
                    <span class="text-xs text-gray-500 flex items-center">
                      <x-icon name="calendar" class="h-3 w-3 mr-1" />
                      {{ $date }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="px-6 py-4 text-sm text-gray-500">No recent invoices found.</div>
          @endforelse
        </div>
      </div>

      <!-- Recent Payments -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
          <x-icon name="dollar-sign" class="h-5 w-5 text-gray-400" />
        </div>
        <div class="divide-y divide-gray-200">
          @forelse($recentPayments as $payment)
            @php
              $inv = $payment->invoice;
              $client = $inv->project->customer_name ?? $inv->invoice_number ?? ($inv->id_invoice ?? '—');
              $amount = $payment->amount ?? 0;
              $amountFormatted = 'Rp' . number_format($amount, 0, ',', '.');
              $date = $payment->payment_date ?? optional($payment->created_at)->toDateString();
              $method = $payment->pay_method ?? $payment->reference ?? '';
            @endphp
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-900">{{ $client }}</p>
                  <p class="text-sm text-gray-600 mt-1">{{ $inv->id_invoice ?? $inv->invoice_number }}</p>
                  <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-semibold text-green-600">{{ $amountFormatted }}</span>
                    <span class="text-xs text-gray-500 flex items-center">
                      <x-icon name="clock" class="h-3 w-3 mr-1" />
                      {{ $date }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="px-6 py-4 text-sm text-gray-500">No recent payments found.</div>
          @endforelse
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
