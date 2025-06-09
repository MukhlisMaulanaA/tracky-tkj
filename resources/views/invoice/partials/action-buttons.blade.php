<div class="mt-8 flex flex-wrap gap-4 justify-between">
  <div class="flex gap-4">
    <button type="button" onclick="resetForm()"
      class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
      <x-icon name="rotate-ccw" class="w-4 h-4" />
      Reset
    </button>

    <button type="button" onclick="window.print()"
      class="px-6 py-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors flex items-center gap-2">
      <x-icon name="printer" class="w-4 h-4" />
      Print
    </button>
  </div>

  <div class="flex gap-4">
    <button type="button" onclick="saveDraft()"
      class="px-6 py-3 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors flex items-center gap-2">
      <x-icon name="save" class="w-4 h-4" />
      Save Draft
    </button>

    <button type="submit" id="submit-btn"
      class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2 font-semibold">
      <x-icon name="send" class="w-4 h-4" />
      <span id="submit-text">Submit Form</span>
    </button>
  </div>
</div>
