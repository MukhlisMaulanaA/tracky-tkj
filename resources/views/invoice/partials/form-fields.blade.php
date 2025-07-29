<!-- Project Details (readonly) -->
<div class="p-6 border-b border-gray-100 space-y-4">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
    <div class="col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
      <input type="text" class="w-full border-gray-300 rounded-md" readonly
        value="{{ optional($invoice->project)->customer_name }}">
    </div>
    <div class="col-span-2 col-start-3">
      <label class="block text-sm font-medium text-gray-700 mb-2">Project Name</label>
      <input type="text" class="w-full border-gray-300 rounded-md" readonly
        value="{{ optional($invoice->project)->project_name }}">
    </div>
    <div class="col-start-5">
      <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
      <input type="text" name="year" value="{{ old('year', $invoice->year) }}"
        class="form-input w-full border-gray-300 rounded-md" required>
    </div>
  </div>
</div>

<!-- Index Details -->
<div class="p-6 border-gray-100">
  <h3 class="text-lg font-semibold text-gray-900 mb-4">Index Details</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">No. PO</label>
      <input type="text" name="po_number" value="{{ old('po_number', $invoice->po_number) }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Number</label>
      <input type="text" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>
  </div>
</div>

<!-- Tanggal dan Info Invoice -->
<div class="p-6 border-b border-gray-100">
  <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tanggal</h3>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Buat</label>
      <input type="date" name="create_date" value="{{ old('create_date', $invoice->create_date) }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Submit</label>
      <input type="date" name="submit_date" value="{{ old('submit_date', $invoice->submit_date) }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
      <input type="date" name="date_payment" value="{{ old('date_payment', $invoice->date_payment) }}"
        class="form-input w-full border-gray-300 rounded-md">
    </div>
  </div>
</div>

<!-- Tax Settings -->
<div class="p-6 border-b border-gray-100">
  <h3 class="text-lg font-semibold text-gray-900 mb-4">Tax Settings</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">VAT %</label>
      <select name="vat_percent"
        class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
        <option value="11" selected>11%</option>
        <option value="12">12%</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">PPH %</label>
      <input type="number" step="0.01" name="pph_percent" value="2"
        class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
        min="0" max="100">
    </div>
  </div>
</div>

<!-- Detail Jumlah -->
<div class="p-6 border-b border-gray-100">
  <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Jumlah</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" name="amount" value="{{ old('amount', number_format($invoice->amount ?? 0, 0, '', ',')) }}"
        class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        VAT <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="vat_11" value="{{ old('vat_11', number_format($invoice->vat_11 ?? 0, 0, '', ',')) }}"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          required readonly>
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        PPH <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="pph_2" value="{{ old('pph_2', number_format($invoice->pph_2 ?? 0, 0, '', ',')) }}"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          required readonly>
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Denda <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="denda" value="{{ old('denda', number_format($invoice->denda ?? 0, 0, '', ',')) }}"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Payment VAT/PPH 11/2
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="payment_vat" value="{{ old('payment_vat', number_format($invoice->payment_vat ?? 0, 0, '', ',')) }}"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          required readonly>
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Real Payment
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="real_payment" value="{{ old('real_payment', number_format($invoice->real_payment ?? 0, 0, '', ',')) }}"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          required readonly>
      </div>
    </div>
  </div>
</div>

<!-- Remark -->
<div class="p-6">
  <label class="block text-sm font-medium text-gray-700 mb-2">Remark</label>
  <textarea name="remark" rows="2" class="form-textarea w-full border-gray-300 rounded-md">{{ old('remark', $invoice->remark) }}</textarea>
</div>
