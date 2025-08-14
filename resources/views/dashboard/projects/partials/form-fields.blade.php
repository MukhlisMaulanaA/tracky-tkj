<div class="space-y-6">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <!-- ID Project -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">ID Project</label>
      <input type="text" name="id_project" value="{{ old('id_project', $project->id_project ?? '') }}"
        class="form-input w-full border-gray-300 rounded-md" required readonly>
      <p class="text-xs text-gray-400 mt-1">Format: PYYM000</p>
    </div>

    <!-- Customer Name -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
      <input type="text" name="customer_name" value="{{ old('customer_name', $project->customer_name ?? '') }}"
        class="form-input w-full border-gray-300 rounded-md" required>
    </div>

    <!-- Project Name -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
      <input type="text" name="project_name" value="{{ old('project_name', $project->project_name ?? '') }}"
        class="form-input w-full border-gray-300 rounded-md" required>
    </div>

    <!-- Location -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
      <input type="text" name="location" value="{{ old('location', $project->location ?? '') }}"
        class="form-input w-full border-gray-300 rounded-md" required>
    </div>

    <!-- Tanggal Submit -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Submit</label>
      <input type="date" name="submit_date" value="{{ old('submit_date', optional($project->submit_date)->format('Y-m-d') ?? '') }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>

    <!-- Tanggal Briefing -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Briefing</label>
      <input type="date" name="briefing_date" value="{{ old('briefing_date', optional($project->briefing_date)->format('Y-m-d') ?? '') }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>

    <!-- Deadline -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
      <input type="date" name="deadline" value="{{ old('deadline', optional($project->deadline)->format('Y-m-d') ?? '') }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>

    <!-- Remarks -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
      <select name="remarks" class="form-select w-full border-gray-300 rounded-md" required>
        <option value="">-- Select Remark --</option>
        @foreach ($remarksOptions as $opt)
          <option value="{{ $opt }}" {{ old('remarks', $project->remarks ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
        @endforeach
      </select>
    </div>

    <!-- Notes -->
    <div class="lg:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
      <textarea name="notes" rows="4"
        class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
        placeholder="Tambahkan catatan...">{{ old('notes', $project->notes ?? '') }}</textarea>
    </div>
  </div>
</div>
