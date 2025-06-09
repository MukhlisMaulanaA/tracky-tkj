@extends('layouts.dashboard')
{{-- @import (asset('../resources/js/invoice-form.js')); --}}
@push('styles')
  <style>
    @media print {
      body * {
        visibility: hidden;
      }

      .print-area,
      .print-area * {
        visibility: visible;
      }

      .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }

      button,
      .no-print {
        display: none !important;
      }
    }
  </style>
@endpush

@section('content')
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-5xl mx-auto">
      {{-- Header --}}
      @include('invoice.partials.header')

      {{-- Notifications --}}
      @include('invoice.partials.notifications')

      {{-- Progress Bar --}}
      @include('invoice.partials.progress-bar')

      {{-- Main Form Card --}}
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
          <h2 class="text-2xl font-semibold text-white flex items-center gap-3">
            <x-icon name="file-text" class="w-6 h-6" />
            Payment Information
          </h2>
        </div>

        <form id="payment-form" action="{{ route('invoice.store') }}" method="POST" class="p-8">
          @csrf

          {{-- Basic Information Section --}}
          @include('invoice.partials.basic-info')

          {{-- Remarks Section --}}
          @include('invoice.partials.remarks')

          {{-- Financial Section --}}
          @include('invoice.partials.financial-info')

          {{-- Action Buttons --}}
          @include('invoice.partials.action-buttons')
        </form>
      </div>

      {{-- Footer --}}
      @include('invoice.partials.footer')
    </div>
  </div>
  @push('scripts')
    <script src={{ mix('../resources/js/invoiceForm.js') }}></script>
  @endpush
@endsection
