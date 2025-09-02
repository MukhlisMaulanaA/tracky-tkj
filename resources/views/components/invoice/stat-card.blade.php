@props(['title', 'value', 'color' => 'gray'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
  <div class="flex items-center justify-between">
    <div>
      <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
      <p class="text-2xl font-bold text-{{ $color }}-600">{{ $value }}</p>
    </div>
    <div class="p-3 bg-{{ $color }}-50 rounded-lg">
      <x-icon name="dollar-sign" class="h-6 w-6 text-{{ $color }}-600" />
    </div>
  </div>
</div>