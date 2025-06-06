@props([
    'name' => 'circle',
    'class' => '',
])

<i data-lucide="{{ $name }}" class="{{ $class }}"></i>

@once
  @push('scripts')
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
      });
    </script>
  @endpush
@endonce
