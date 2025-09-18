@extends('layouts.dashboard')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Payment Tracker</h1>
        <p class="mt-2 text-gray-600">Manage and track all your payments in one place</p>
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
          New Payment
        </button>
      </div>
    </div>

    {{-- <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <x-payment.stat-card title="Total Payments" :value="'Rp' . number_format($totalPayments, 0, ',', '.')" color="blue" />
      <x-payment.stat-card title="Completed Payments" :value="'Rp' . number_format($completedPayments, 0, ',', '.')" color="green" />
      <x-payment.stat-card title="Pending Payments" :value="'Rp' . number_format($pendingPayments, 0, ',', '.')" color="black" />
    </div> --}}

  {{-- status not stored on payments; filtering kept on invoices only so remove status filter UI --}}

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table id="payment-table" class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th>No.</th>
              <th>ID Payment</th>
              <th>Invoice</th>
              <th>Customer</th>
              <th>Amount</th>
              <th>Payment Date</th>
              <th>Payment Method</th>
              <th>Reference</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        const table = $('#payment-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: '{{ route('payments.datatable') }}',
          },
          columns: [
            {
              data: null,
              name: 'no',
              orderable: false,
              searchable: false
            },
            {
              data: 'id_payment',
            },
            {
              data: 'invoice_number',
            },
            {
              data: 'customer_name',
            },
            {
              data: 'amount',
            },
            {
              data: 'payment_date',
            },
            {
              data: 'pay_method',
            },
            {
              data: 'reference',
            },
            {
              data: 'action',
            },
          ],
          columnDefs: [
            {
              targets: 0,
              render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
              }
            }
          ],
          createdRow: function(row, data, dataIndex) {
            $(row).addClass('text-sm');
          },
        });

        $('#filter-status').change(function() {
          table.ajax.reload();
        });
      });
    </script>
    <script>
      (function() {
        function initProofModal() {
          // create modal markup and append once
          let modal = document.getElementById('payment-proof-modal');
          if (!modal) {
            modal = document.createElement('div');
            modal.id = 'payment-proof-modal';
            modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60';
            modal.innerHTML = `
              <div class="relative max-w-4xl w-full mx-4">
                <button id="payment-proof-modal-close" class="absolute right-0 top-0 mt-2 mr-2 text-white bg-gray-800 bg-opacity-60 hover:bg-opacity-80 rounded-full w-8 h-8 flex items-center justify-center" aria-label="Close image modal">×</button>
                <div class="bg-white rounded shadow-lg overflow-hidden">
                  <img id="payment-proof-modal-img" src="" alt="Proof image" class="w-full h-auto object-contain max-h-[80vh] bg-black">
                </div>
              </div>`;
            document.body.appendChild(modal);
          }

          const modalImg = document.getElementById('payment-proof-modal-img');
          const closeBtn = document.getElementById('payment-proof-modal-close');
          if (!modalImg || !closeBtn) return;

          function openModal(url) {
            modalImg.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            closeBtn.focus();
          }

          function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalImg.src = '';
          }

          // delegated click for buttons produced by DataTables
          document.addEventListener('click', function(e) {
            const btn = e.target.closest && e.target.closest('.view-proof-btn');
            if (!btn) return;
            const url = btn.getAttribute('data-proof');
            if (!url) return;
            openModal(url);
          });

          closeBtn.addEventListener('click', closeModal);

          modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
          });

          document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.key === 'Esc') {
              if (!modal.classList.contains('hidden')) closeModal();
            }
          });
        }

        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initProofModal);
        else initProofModal();
      })();
    </script>
  @endpush

  @push('styles')
    <style>
      table#payment-table th,
      table#payment-table td {
        vertical-align: top;
      }

      table#payment-table td {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
      }
    </style>
  @endpush
@endsection