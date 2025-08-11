@extends('dashboard') {{-- Sesuaikan dengan path dashboard.blade.php kamu --}}

@section('title', 'Detail Proyek')

@section('content')
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 px-6 py-4">
      <div class="flex items-center justify-between max-w-7xl mx-auto">
        <!-- Back Button and Title -->
        <div class="flex items-center space-x-4">
          <a href="{{ route('projects.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
            <i class="fas fa-arrow-left text-lg"></i>
          </a>
          <h1 class="text-xl font-semibold text-gray-900">Detail Proyek</h1>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-4">
          <a href="{{ route('projects.edit', $project->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center space-x-2">
            <i class="fas fa-edit text-sm"></i>
            <span>Edit Proyek</span>
          </a>
          <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-medium">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-6 space-y-6">

      {{-- Detail Proyek --}}
      @include('projects.partials.detail-card')

      {{-- Pesanan Pembelian --}}
      @include('projects.partials.purchase-orders')

      {{-- Pelacakan Kemajuan --}}
      @include('projects.partials.progress-tracking')

      {{-- Pelacakan Kemajuan Sub --}}
      @include('projects.partials.sub-progress')

      {{-- Berita Acara Serah Terima --}}
      @include('projects.partials.delivery-reports')

    </main>

    <!-- Help Button -->
    <div class="fixed bottom-6 right-6">
      <button
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg hover:shadow-xl transition-all">
        <i class="fas fa-question text-sm"></i>
      </button>
      <span
        class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 hover:opacity-100 transition-opacity whitespace-nowrap">
        Bantuan
      </span>
    </div>
  </div>
@endsection
