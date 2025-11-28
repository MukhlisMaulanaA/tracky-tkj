@extends('layouts.dashboard')

@section('title', 'Buat Purchase Order')

@section('content')
	<div class="min-h-screen bg-gray-50 py-8 px-4">
		<div class="max-w-4xl mx-auto">

			<div class="mb-6">
				<h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Purchase Order Baru</h1>
				<p class="text-sm text-gray-600">Unggah dokumen PO dan lengkapi informasi berikut</p>
			</div>

			<form method="POST" action="{{ route('purchase_orders.store') }}" enctype="multipart/form-data" class="space-y-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
				@csrf

				<div class="grid grid-cols-1 gap-4">
					<div>
						<label class="block text-sm font-medium text-gray-700">ID PO</label>
						<input type="text" name="id_po" id="id_po" value="{{ old('id_po', $purchaseOrder->id_po ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700">Nomor PO</label>
						<input type="text" name="po_number" id="po_number" value="{{ old('po_number', $purchaseOrder->po_number ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700">Pilih Project</label>
						<select id="id_project" name="project_id" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
							<option value="">-- Pilih Project --</option>
							@if(!empty($projects))
								@foreach($projects as $project)
									<option value="{{ $project->id_project }}">{{ $project->id_project }} - {{ $project->project_name }}</option>
								@endforeach
							@endif
						</select>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
						<input type="date" name="created_date" value="{{ old('created_date', now()->toDateString()) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700">Total Value</label>
						<input type="number" name="total_value" step="0.01" value="{{ old('total_value', $purchaseOrder->total_value ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700">Status</label>
						<select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
							<option value="Draft">Draft</option>
							<option value="Approved">Approved</option>
							<option value="In Progress">In Progress</option>
							<option value="Completed">Completed</option>
						</select>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700">Dokumen PO (attachment)</label>
						<input type="file" name="document" accept=".pdf,.doc,.docx,image/*" class="w-full mt-1">
						<p class="text-xs text-gray-500 mt-1">Format disarankan: PDF / DOC / JPG. Maks 10MB.</p>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700">Catatan</label>
						<textarea name="note" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('note', $purchaseOrder->note ?? '') }}</textarea>
					</div>
				</div>

				<div class="flex justify-end space-x-3">
					<a href="{{ route('purchase_orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm">Batal</a>
					<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">Simpan Purchase Order</button>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('styles')
	<style>
		/* reuse small select2 tweaks if select2 is loaded in the layout */
		.select2-container--default .select2-selection--single { height: 42px !important; }
	</style>
@endpush

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Initialize select2 if available
			if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
				$('#id_project').select2({
					ajax: {
						url: '{{ route('projects.select2') }}',
						dataType: 'json',
						delay: 250,
						processResults: function(data) { return { results: data }; }
					},
					placeholder: '-- Pilih Project --',
					minimumInputLength: 0,
					width: '100%'
				});

				$('#id_project').one('focus', function() { $(this).select2('open'); });
			}

			// When project changes, fetch details to optionally fill other fields
			const projectSelect = document.getElementById('id_project');
			if (projectSelect) {
				projectSelect.addEventListener('change', function() {
					const projectId = this.value;
					if (!projectId) return;

					// Set loading state on po_number
					const poField = document.getElementById('po_number');
					if (poField) { poField.value = 'Loading...'; }

					fetch(`/projects/${projectId}/detail`)
						.then(response => response.ok ? response.json() : Promise.reject())
						.then(data => {
							if (data.nomor_po && poField) poField.value = data.nomor_po;
						})
						.catch(() => {
							if (poField) poField.value = '';
						});
				});
			}
		});
	</script>
@endpush

