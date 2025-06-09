<div class="mt-6 space-y-2">
  <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
    <x-icon name="file-text" class="w-4 h-4" />
    Remarks
  </label>
  <textarea name="remark" rows="4"
    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none @error('remark') border-red-300 @enderror"
    placeholder="Enter any additional remarks or notes...">{{ old('remark', $payment->remark ?? '') }}</textarea>
  @error('remark')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>
