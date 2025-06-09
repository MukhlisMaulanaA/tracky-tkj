{{-- Success Notification --}}
<div id="success-notification"
  class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 hidden">
  <x-icon name="check-circle" class="w-5 h-5 text-green-600" />
  <span class="text-green-800">Form submitted successfully!</span>
</div>

{{-- Error Notification --}}
<div id="error-notification" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 hidden">
  <x-icon name="alert-circle" class="w-5 h-5 text-red-600" />
  <span id="error-message" class="text-red-800"></span>
  <button type="button" onclick="hideError()" class="ml-auto text-red-600 hover:text-red-800">
    ×
  </button>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
  <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
    <div class="flex items-center gap-3 mb-2">
      <x-icon name="alert-circle" class="w-5 h-5 text-red-600" />
      <span class="text-red-800 font-medium">Please fix the following errors:</span>
    </div>
    <ul class="list-disc list-inside text-sm text-red-700">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
