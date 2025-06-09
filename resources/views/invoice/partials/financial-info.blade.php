<div class="mt-8">
  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
    <x-icon name="dollar-sign" class="w-5 h-5" />
    Financial Information
  </h3>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    {{-- Amount --}}
    <x-form.currency name="amount" label="Amount" required :value="old('amount', $payment->amount ?? '')" />

    {{-- VAT 11% - Auto-calculated --}}
    <x-form.currency name="vat_11" label="VAT 11% (Auto)" readonly :value="old('vat_11', $payment->vat_11 ?? '')" />

    {{-- PPH 2% - Auto-calculated --}}
    <x-form.currency name="pph_2" label="PPH 2% (Auto)" readonly :value="old('pph_2', $payment->pph_2 ?? '')" />

    {{-- Fine --}}
    <x-form.currency name="fine" label="Fine" :value="old('fine', $payment->fine ?? '')" />

    {{-- Payment VAT - Auto-calculated --}}
    <x-form.currency name="payment_vat" label="Payment + VAT (Auto)" readonly class="font-semibold" :value="old('payment_vat', $payment->payment_vat ?? '')" />

    {{-- Real Payment --}}
    <x-form.currency name="real_payment" label="Real Payment" :value="old('real_payment', $payment->real_payment ?? '')" />
  </div>
</div>
