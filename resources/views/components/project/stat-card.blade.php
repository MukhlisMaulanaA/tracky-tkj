@props(['title', 'count', 'color' => 'text-gray-800', 'icon', 'layoutClass' => ''])

<div class="{{ $layoutClass }}">
  <div class="flex items-center justify-between p-6 rounded-lg shadow-sm bg-white">
    <div>
      <p class="text-3xl font-extrabold text-{{ $color }}-600">{{ $count }}</p>
      <h4 class="mt-1 text-sm font-medium text-gray-600">{{ $title }}</h4>
    </div>
    <div class="p-3 bg-{{ $color }}-50 rounded-lg">
      <x-icon name="{{ $icon }}" class="h-6 w-6 text-{{ $color }}-600" />
    </div>
  </div>
</div>