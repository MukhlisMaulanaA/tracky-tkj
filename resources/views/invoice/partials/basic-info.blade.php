<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
  <select id="id_project" name="id_project" class="form-select" required>
    <option value="">-- Pilih Project --</option>
    @foreach ($projects as $project)
      <option value="{{ $project->id_project }}">{{ $project->id_project }} - {{ $project->project_name }}</option>
    @endforeach
  </select>

  {{-- Year --}}
  <x-form.select name="year" label="Year" icon="calendar" required :options="$years" :value="old('year', $payment->year ?? date('Y'))" />

  {{-- Project Name --}}
  <x-form.input name="project_name" label="Project Name" icon="building" required placeholder="Enter project name"
    :value="old('project_name', $payment->project_name ?? '')" list="project-suggestions" />
  <datalist id="project-suggestions">
    @foreach ($projectSuggestions as $suggestion)
      <option value="{{ $suggestion }}">
    @endforeach
  </datalist>

  {{-- Create Date --}}
  <x-form.input type="date" name="create_date" label="Create Date" icon="calendar" :value="old('create_date', $payment->create_date ?? '')" />

  {{-- Submit Date --}}
  <x-form.input type="date" name="submit_date" label="Submit Date" icon="calendar" :value="old('submit_date', $payment->submit_date ?? '')" />

  {{-- Payment Date --}}
  <x-form.input type="date" name="date_payment" label="Payment Date" icon="calendar" :value="old('date_payment', $payment->date_payment ?? '')" />

  {{-- PO Number --}}
  <x-form.input name="po_number" label="PO Number" icon="file-text" placeholder="PO-2024-0001" pattern="PO-\d{4}-\d+"
    :value="old('po_number', $payment->po_number ?? '')" help="Format: PO-YYYY-XXXX" />

  {{-- Invoice Number --}}
  <x-form.input name="invoice_number" label="Invoice Number" icon="file-text" placeholder="INV-2024-0001"
    pattern="INV-\d{4}-\d+" :value="old('invoice_number', $payment->invoice_number ?? '')" help="Format: INV-YYYY-XXXX" />

  {{-- Customer Name --}}
  <x-form.input name="customer_name" label="Customer Name" icon="user" required placeholder="Enter customer name"
    :value="old('customer_name', $payment->customer_name ?? '')" list="customer-suggestions" />
  <datalist id="customer-suggestions">
    @foreach ($customerSuggestions as $suggestion)
      <option value="{{ $suggestion }}">
    @endforeach
  </datalist>
</div>
