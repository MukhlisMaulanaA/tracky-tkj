<div class="bg-white rounded-lg shadow p-6 space-y-4">
  <div class="flex items-center space-x-3 mb-6">
    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
      <x-icon name="construction" class="w-6 h-6 text-blue-600"></x-icon>
    </div>
    <h2 class="text-lg font-semibold text-gray-900">Informasi Proyek</h2>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Project ID -->
    <div>
      <label class="text-sm font-medium text-gray-500 mb-1 block">ID Proyek</label>
      <p class="text-base font-semibold text-gray-900">{{ $project->id_project }}</p>
    </div>

    <!-- Project Name -->
    <div>
      <label class="text-sm font-medium text-gray-500 mb-1 block">Nama Proyek</label>
      <p class="text-base font-semibold text-gray-900">{{ $project->project_name }}</p>
    </div>

    <!-- Customer Name -->
    <div>
      <label class="text-sm font-medium text-gray-500 mb-1 block">Nama Pelanggan</label>
      <p class="text-base font-semibold text-gray-900">{{ $project->customer_name }}</p>
    </div>

    <!-- Location -->
    <div>
      <label class="text-sm font-medium text-gray-500 mb-1 block">Lokasi</label>
      <p class="text-base font-semibold text-gray-900">{{ $project->location }}</p>
    </div>

    <!-- Status -->
    <div>
      <label class="text-sm font-medium text-gray-500 mb-1 block">Status</label>
      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
        <i class="fas fa-circle text-yellow-400 mr-1 text-xs"></i>
        {{ $project->remarks }}
      </span>
    </div>

    <!-- Start Date -->
    <div>
      <label class="text-sm font-medium text-gray-500 mb-1 block">Tanggal Briefing</label>
      <p class="text-base font-semibold text-gray-900">{{ $briefingDate }}</p>
    </div>
  </div>
</div>
