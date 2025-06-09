@props(['name', 'label', 'required' => false, 'readonly' => false, 'value' => '', 'class' => ''])

<div class="space-y-2">
  <label for="{{ $name }}" class="text-sm font-medium text-gray-700">
    {{ $label }}
    @if ($required)
      <span class="text-red-500">*</span>
    @endif
  </label>
  <input type="text" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}" placeholder="Rp 0"
    @if ($required) required @endif @if ($readonly) readonly @endif
    class="currency-input w-full px-4 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $class }}
               @error($name) border-red-300 @else @if ($readonly) border-gray-100 bg-gray-50 text-gray-600 @else border-gray-200 @endif @enderror">
  @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>
