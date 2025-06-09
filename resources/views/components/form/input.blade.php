@props([
    'name',
    'label',
    'type' => 'text',
    'icon' => null,
    'required' => false,
    'readonly' => false,
    'help' => null,
    'value' => '',
    'placeholder' => '',
    'pattern' => null,
    'list' => null,
])

<div class="space-y-2">
  <label for="{{ $name }}" class="flex items-center gap-2 text-sm font-medium text-gray-700">
    @if ($icon)
      <x-icon name="{{ $icon }}" class="w-4 h-4" />
    @endif
    {{ $label }}
    @if ($required)
      <span class="text-red-500">*</span>
    @endif
    @if ($help)
      <div class="group relative">
        <x-icon name="info" class="w-4 h-4 text-gray-400 cursor-help" />
        <div
          class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
          {{ $help }}
        </div>
      </div>
    @endif
  </label>
  <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}"
    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
    @if ($pattern) pattern="{{ $pattern }}" @endif
    @if ($list) list="{{ $list }}" @endif
    @if ($required) required @endif @if ($readonly) readonly @endif
    class="w-full px-4 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors 
               @error($name) border-red-300 @else border-gray-200 @enderror
               @if ($readonly) bg-gray-50 text-gray-600 @endif">
  @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>
