@extends('layouts.dashboard')

@section('content')
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Payment</h2>

    <form action="{{ route('payments.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- LEFT: inputs -->
        <div class="space-y-4">
          <!-- Select2 Invoice -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Invoice</label>
            <select id="id_invoice" name="id_invoice" class="w-full"></select>
          </div>

          <!-- Detail singkat invoice -->
          <div id="invoice-details" class="hidden p-4 bg-gray-50 rounded border border-gray-200">
            <div class="grid grid-cols-1 gap-2 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-600">ID Invoice</span>
                <span id="detail-id" class="font-medium text-gray-800"></span>
              </div>

              <div class="flex justify-between">
                <span class="text-gray-600">Invoice Number</span>
                <span id="detail-number" class="font-medium text-gray-800"></span>
              </div>

              <div class="flex justify-between">
                <span class="text-gray-600">Customer</span>
                <span id="detail-customer" class="font-medium text-gray-800"></span>
              </div>

              <div class="flex justify-between">
                <span class="text-gray-600">Tagihan</span>
                <span id="detail-tagihan" class="font-medium text-gray-800"></span>
              </div>

              <!-- Unpaid row (added) -->
              <div class="flex justify-between items-center">
                <span class="text-gray-600">Sisa belum dibayar</span>
                <span id="detail-unpaid" class="font-semibold text-red-600">-</span>
              </div>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
            <input type="text" step="0.01" name="amount" data-type="rupiah" required
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
            <input type="datetime-local" name="payment_date" step="1" required
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
            <input type="text" name="pay_method"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Nomor Referensi</label>
            <input type="text" name="reference"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Catatan</label>
            <textarea name="notes" rows="3"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
          </div>

          <!-- Proof image upload -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Bukti Pembayaran (opsional)</label>
            <input id="proof_image_input" type="file" name="proof_image" accept="image/*"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @error('proof_image')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mt-4 w-full">
            <div class="flex justify-center">
              <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            </div>

            @error('g-recaptcha-response')
              <div class="mt-2 text-sm text-red-600 dark:text-red-400 text-center">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
              Submit Payment
            </button>
          </div>
        </div>

        <!-- RIGHT: preview pane -->
        <div>
          <div class="h-full border border-gray-200 rounded p-4 flex flex-col items-center justify-start">
            <p class="text-sm text-gray-600 mb-3">Preview Bukti Pembayaran</p>

            <div id="preview-wrapper" class="relative w-full bg-gray-50 rounded overflow-hidden"
              style="min-height:320px;">
              <!-- zoom pane (hidden until image loaded) -->
              <div id="zoom-cursor" class="absolute inset-0 cursor-zoom-in" style="display:none;">
                <img id="preview-image" src="" alt="Preview" class="object-contain w-full h-full"
                  style="transform-origin: 0 0; transition: transform 0.05s linear;">
              </div>

              <!-- placeholder -->
              <div id="preview-placeholder" class="w-full h-full flex items-center justify-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3H8a2 2 0 00-2 2v0h12v0a2 2 0 00-2-2z" />
                </svg>
              </div>
            </div>

            <div class="mt-3 w-full text-center">
              <button id="open-window-btn" type="button" class="px-3 py-1 bg-gray-200 rounded mr-2" disabled>Open in
                Window</button>
              <button id="open-modal-btn" type="button" class="px-3 py-1 bg-gray-200 rounded" disabled>Open
                Modal</button>
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#id_invoice').select2({
        ajax: {
          url: '{{ route('payments.invoices.select2') }}',
          dataType: 'json',
          delay: 250,
          data: params => ({
            q: params.term
          }),
          processResults: data => data
        },
        placeholder: '-- Pilih Invoice --',
        minimumInputLength: 0,
        width: '100%'
      });

      $('#id_invoice').on('change', function() {
        const id_invoice = $(this).val();
        if (!id_invoice) return $('#invoice-details').addClass('hidden');

        fetch(`/payments/invoices/${id_invoice}/detail`)
          .then(res => res.json())
          .then(data => {
            // helper: ensure we have a formatted rupiah string
            function formatRupiah(number, withDecimals = false) {
              if (number === null || number === undefined) return '-';
              const n = withDecimals ? Number(number).toFixed(2) : Math.round(Number(number));
              return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            $('#detail-id').text(data.id_invoice);
            $('#detail-number').text(data.invoice_number);
            $('#detail-customer').text(data.customer_name);
            // data.payment_vat is already formatted on server with 2 decimals; keep displayed value but strip decimals for consistency
            $('#detail-tagihan').text(data.payment_vat);

            // prefer explicit unpaid numeric if provided, otherwise try to parse from note
            let unpaidValue = null;
            if (data.unpaid !== undefined) {
              unpaidValue = Number(data.unpaid);
            } else if (data.note) {
              // try to extract digits from note like 'Sisa belum dibayar: Rp 1.234.567'
              const digits = (data.note.match(/Rp\s*([\d\.]+)/) || [null, null])[1];
              if (digits) unpaidValue = Number(digits.replace(/\./g, ''));
            }

            if (unpaidValue === null || isNaN(unpaidValue)) {
              $('#detail-unpaid').text('-').removeClass('text-green-600').addClass('text-red-600');
            } else {
              const formatted = 'Rp ' + formatRupiah(unpaidValue, false);
              $('#detail-unpaid').text(formatted);
              if (unpaidValue <= 0) {
                $('#detail-unpaid').removeClass('text-red-600').addClass('text-green-600');
              } else {
                $('#detail-unpaid').removeClass('text-green-600').addClass('text-red-600');
              }
            }

            $('#invoice-details').removeClass('hidden');
          });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      // format angka: "1234567" -> "1,234,567"
      function formatNumberWithCommas(strDigits) {
        if (!strDigits) return '';
        return strDigits.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      // cari semua input yang butuh format rupiah
      const rupiahInputs = document.querySelectorAll('input[data-type="rupiah"]');

      rupiahInputs.forEach(function(input) {
        // format initial value (jika ada)
        const initialDigits = (input.value || '').toString().replace(/[^\d]/g, '');
        if (initialDigits !== '') {
          input.value = formatNumberWithCommas(initialDigits);
        } else {
          input.value = '';
        }

        // handle typing (preserve caret using count of digits before caret)
        input.addEventListener('input', function(e) {
          const raw = input.value;
          // jumlah digit di kiri kursor (sebelum format)
          const cursorPos = input.selectionStart || 0;
          const digitsBeforeCursor = raw.slice(0, cursorPos).replace(/[^\d]/g, '').length;

          // strip non-digit -> format
          const onlyDigits = raw.replace(/[^\d]/g, '');
          const formatted = formatNumberWithCommas(onlyDigits);

          input.value = formatted;

          // restore caret at posisi berdasarkan jumlah digit di kiri
          let pos = 0;
          let digitsSeen = 0;
          while (pos < formatted.length && digitsSeen < digitsBeforeCursor) {
            if (/\d/.test(formatted[pos])) digitsSeen++;
            pos++;
          }
          // set caret (safely)
          try {
            input.setSelectionRange(pos, pos);
          } catch (err) {
            // ignore if not supported
          }
        });

        // handle paste: accept numbers only
        input.addEventListener('paste', function(e) {
          e.preventDefault();
          const text = (e.clipboardData || window.clipboardData).getData('text') || '';
          const digits = text.replace(/[^\d]/g, '');
          input.value = formatNumberWithCommas(digits);
          // place caret at end
          try {
            input.setSelectionRange(input.value.length, input.value.length);
          } catch (e) {}
        });

        // If inside a form, sanitize before submit (replace non-digits so server receives plain digits)
        const form = input.closest('form');
        if (form) {
          form.addEventListener('submit', function() {
            // replace every rupiah input value with digits-only (no commas)
            form.querySelectorAll('input[data-type="rupiah"]').forEach(function(r) {
              r.value = (r.value || '').toString().replace(/[^\d]/g, '') || '0';
            });
          });
        }
      });
    });

    // fungsi preview image
    (function() {
      function initPreview() {
        // Elements (guarded)
        const fileInput = document.getElementById('proof_image_input');
        const previewWrapper = document.getElementById('preview-wrapper');
        const previewImage = document.getElementById('preview-image');
        const previewPlaceholder = document.getElementById('preview-placeholder');
        const zoomCursor = document.getElementById('zoom-cursor');
        const openWindowBtn = document.getElementById('open-window-btn');
        const openModalBtn = document.getElementById('open-modal-btn');

        // If critical elements are missing, skip initialization
        if (!fileInput || !previewWrapper || !previewImage || !previewPlaceholder || !zoomCursor) return;

        let imgNaturalWidth = 0;
        let imgNaturalHeight = 0;
        let currentDataUrl = null;

        // Create modal overlay (hidden) if not already present
        let modal = document.getElementById('proof-modal-overlay');
        if (!modal) {
          modal = document.createElement('div');
          modal.id = 'proof-modal-overlay';
          modal.style.display = 'none';
          modal.style.position = 'fixed';
          modal.style.inset = '0';
          modal.style.zIndex = '60';
          modal.style.background = 'rgba(0,0,0,0.6)';
          modal.style.alignItems = 'center';
          modal.style.justifyContent = 'center';
          modal.innerHTML =
            '<div style="max-width:90%; max-height:90%;"><img id="modal-image" style="width:100%; height:auto; border-radius:6px;" src="" alt="Full image" /></div>';
          document.body.appendChild(modal);
          modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.style.display = 'none';
          });
        }

        function enablePreview(dataUrl) {
          currentDataUrl = dataUrl;
          if (previewPlaceholder) previewPlaceholder.style.display = 'none';
          if (zoomCursor) zoomCursor.style.display = 'block';
          if (previewImage) previewImage.src = dataUrl;
          if (openWindowBtn) openWindowBtn.disabled = false;
          if (openModalBtn) openModalBtn.disabled = false;

          // measure natural size
          const tmp = new Image();
          tmp.onload = function() {
            imgNaturalWidth = tmp.naturalWidth;
            imgNaturalHeight = tmp.naturalHeight;
          };
          tmp.src = dataUrl;
        }

        function disablePreview() {
          currentDataUrl = null;
          if (previewPlaceholder) previewPlaceholder.style.display = '';
          if (zoomCursor) zoomCursor.style.display = 'none';
          if (previewImage) previewImage.src = '';
          if (openWindowBtn) openWindowBtn.disabled = true;
          if (openModalBtn) openModalBtn.disabled = true;
        }

        // file change
        fileInput.addEventListener('change', function(e) {
          const file = e.target.files && e.target.files[0];
          if (!file) {
            disablePreview();
            return;
          }
          if (!file.type.startsWith('image/')) {
            alert('Pilih file gambar.');
            fileInput.value = '';
            disablePreview();
            return;
          }

          const reader = new FileReader();
          reader.onload = function(ev) {
            enablePreview(ev.target.result);
          };
          reader.readAsDataURL(file);
        });

        // Open in new window (simple)
        if (openWindowBtn) {
          openWindowBtn.addEventListener('click', function() {
            if (!currentDataUrl) return;
            const w = window.open('', '_blank');
            if (!w) {
              alert('Popup blocked. Izinkan popups untuk melihat gambar.');
              return;
            }
            const html =
              `<!doctype html><html><head><title>Image</title></head><body style="margin:0;display:flex;align-items:center;justify-content:center;background:#111;color:#fff;"><img src="${currentDataUrl}" style="max-width:100%;height:auto;" /></body></html>`;
            w.document.write(html);
            w.document.close();
          });
        }

        // Open modal
        if (openModalBtn) {
          openModalBtn.addEventListener('click', function() {
            if (!currentDataUrl) return;
            const modalImage = document.getElementById('modal-image');
            if (modalImage) modalImage.src = currentDataUrl;
            modal.style.display = 'flex';
          });
        }

        // Cursor-follow zooming on preview wrapper
        const maxZoom = 2.5;

        if (previewWrapper) {
          previewWrapper.addEventListener('mousemove', function(e) {
            if (!currentDataUrl) return;
            const rect = previewWrapper.getBoundingClientRect();
            const x = e.clientX - rect.left; // x within preview
            const y = e.clientY - rect.top; // y within preview

            // compute scaled size relative to container
            const containerW = rect.width;
            const containerH = rect.height;

            // compute image display size (contain)
            const imgRatio = imgNaturalWidth && imgNaturalHeight ? imgNaturalWidth / imgNaturalHeight : 1;
            let displayW = containerW;
            let displayH = containerW / imgRatio;
            if (displayH > containerH) {
              displayH = containerH;
              displayW = containerH * imgRatio;
            }

            // offset of image within container (centered)
            const offsetX = (containerW - displayW) / 2;
            const offsetY = (containerH - displayH) / 2;

            // position over image
            const overX = Math.max(0, Math.min(displayW, x - offsetX));
            const overY = Math.max(0, Math.min(displayH, y - offsetY));

            const percentX = displayW ? (overX / displayW) : 0.5;
            const percentY = displayH ? (overY / displayH) : 0.5;

            const zoom = maxZoom;

            const originX = percentX * 100;
            const originY = percentY * 100;

            if (previewImage) {
              previewImage.style.transformOrigin = `${originX}% ${originY}%`;
              previewImage.style.transform = `scale(${zoom})`;
            }
            if (zoomCursor) zoomCursor.style.cursor = 'zoom-out';
          });

          // Reset zoom on mouse leave
          previewWrapper.addEventListener('mouseleave', function() {
            if (previewImage) {
              previewImage.style.transform = 'scale(1)';
              previewImage.style.transformOrigin = '0 0';
            }
            if (zoomCursor) zoomCursor.style.cursor = 'zoom-in';
          });

          // Click toggles full-size modal
          previewWrapper.addEventListener('click', function() {
            if (!currentDataUrl) return;
            const modalImage = document.getElementById('modal-image');
            if (modalImage) modalImage.src = currentDataUrl;
            modal.style.display = 'flex';
          });
        }

        // initialize disabled state
        disablePreview();
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPreview);
      } else {
        initPreview();
      }
    })();
  </script>
@endpush
