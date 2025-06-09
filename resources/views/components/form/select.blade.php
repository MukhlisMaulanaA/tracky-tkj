@props(['name', 'label', 'icon' => null, 'required' => false, 'options' => [], 'value' => ''])

<div class="space-y-2">
  <label for="{{ $name }}" class="flex items-center gap-2 text-sm font-medium text-gray-700">
    @if ($icon)
      <x-icon name="{{ $icon }}" class="w-4 h-4" />
    @endif
    {{ $label }}
    @if ($required)
      <span class="text-red-500">*</span>
    @endif
  </label>
  <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif
    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error($name) border-red-300 @enderror">
    @foreach ($options as $optionValue => $optionLabel)
      <option value="{{ $optionValue }}" @if ($value == $optionValue) selected @endif>
        {{ $optionLabel }}
      </option>
    @endforeach
  </select>
  @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>
