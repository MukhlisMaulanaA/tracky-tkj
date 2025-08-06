<!-- Project Details (readonly) -->
<div class="p-6 border-b border-gray-100 space-y-4">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
    <div class="col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
      <input type="text" class="w-full border-gray-300 rounded-md" readonly
        value="{{ optional($invoice->project)->customer_name }}" id="customer_name">
    </div>
    <div class="col-span-2 col-start-3">
      <label class="block text-sm font-medium text-gray-700 mb-2">Project Name</label>
      <input type="text" class="w-full border-gray-300 rounded-md" readonly
        value="{{ optional($invoice->project)->project_name }}" id="project_name">
    </div>
    <div class="col-start-5">
      <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
      <input type="text" name="year" value="{{ old('year', $invoice->year) }}"
        class="form-input w-full border-gray-300 rounded-md" id="year" required>
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
        class="form-input w-full border-gray-300 rounded-md" id="po_number">
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
        <option value="11" {{ old('vat_percent', $invoice->vat_percent ?? 11) == 11 ? 'selected' : '' }}>11%</option>
        <option value="12" {{ old('vat_percent', $invoice->vat_percent ?? 11) == 12 ? 'selected' : '' }}>12%</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">PPH %</label>
      <input type="number" step="0.01" name="pph_percent"
        class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
        min="0" max="100"
        value="{{ old('pph_percent', $invoice->pph_percent ?? 2) }}">
    </div>
  </div>
</div>

<!-- Detail Jumlah -->
<div class="p-6 border-b border-gray-100">
  <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Jumlah</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Amount <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" name="amount" required
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          placeholder="0.00"
          value="{{ old('amount', $invoice->amount ?? '') }}">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        VAT <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="vat" required
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          placeholder="0.00" readonly
          value="{{ old('vat', $invoice->vat ?? '') }}">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        PPH <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="pph" required
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          placeholder="0.00" readonly
          value="{{ old('pph', $invoice->pph ?? '') }}">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Denda</label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="denda"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          placeholder="0.00"
          value="{{ old('denda', $invoice->denda ?? '') }}">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Payment VAT/PPH 11/2</label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="payment_vat"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          placeholder="0.00"
          value="{{ old('payment_vat', $invoice->payment_vat ?? '') }}">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Real Payment</label>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
        <input type="text" step="0.01" name="real_payment"
          class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
          placeholder="0.00"
          value="{{ old('real_payment', $invoice->real_payment ?? '') }}">
      </div>
    </div>
  </div>
  <div class="mt-4">
    <button type="button" id="btn-hitung-otomatis"
      class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
      Re-calculate
    </button>
  </div>
</div>

<!-- Remark -->
<div class="p-6">
  <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
  <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
    <div class="flex space-x-2" id="remark-group">
      @php
        $remarkValue = old('remarks', $invoice->remarks ?? '');
      @endphp
      <label class="cursor-pointer">
        <input type="radio" name="remarks" value="DONE PAYMENT" class="hidden" {{ $remarkValue == 'DONE PAYMENT' ? 'checked' : '' }}>
        <span data-value="DONE PAYMENT"
          class="remark-button inline-block px-4 py-2 rounded-full text-sm font-medium border bg-gray-100 text-gray-700 border-gray-300">
          DONE
        </span>
      </label>
      <label class="cursor-pointer">
        <input type="radio" name="remarks" value="PROCES PAYMENT" class="hidden" {{ $remarkValue == 'PROCES PAYMENT' ? 'checked' : '' }}>
        <span data-value="PROCES PAYMENT"
          class="remark-button inline-block px-4 py-2 rounded-full text-sm font-medium border bg-gray-100 text-gray-700 border-gray-300">
          PROCES
        </span>
      </label>
      <label class="cursor-pointer">
        <input type="radio" name="remarks" value="WAITING PAYMENT" class="hidden" {{ $remarkValue == 'WAITING PAYMENT' ? 'checked' : '' }}>
        <span data-value="WAITING PAYMENT"
          class="remark-button inline-block px-4 py-2 rounded-full text-sm font-medium border bg-gray-100 text-gray-700 border-gray-300">
          WAITING
        </span>
      </label>
    </div>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
    <textarea name="notes" rows="3"
      class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
      placeholder="Tambahkan catatan atau keterangan tambahan...">{{ old('notes', $invoice->notes ?? '') }}</textarea>
  </div>
</div>
