let isDirty = false;
let autoSaveTimer = null;

document.addEventListener("DOMContentLoaded", function () {
    initializeForm();
    setupEventListeners();
    loadDraft();
    startAutoSave();
});

function initializeForm() {
    // Set current year
    const yearSelect = document.querySelector('select[name="year"]');
    if (yearSelect && !yearSelect.value) {
        yearSelect.value = new Date().getFullYear().toString();
    }

    // Initialize currency formatting
    initializeCurrencyInputs();
}

function setupEventListeners() {
    // Form submission
    const form = document.getElementById("payment-form");
    form.addEventListener("submit", handleFormSubmit);

    // Track form changes
    form.addEventListener("input", function () {
        isDirty = true;
        updateLastUpdated();
    });

    // Amount calculation
    const amountInput = document.querySelector('input[name="amount"]');
    if (amountInput) {
        amountInput.addEventListener("input", calculateTaxFields);
    }

    // Currency inputs - perbaikan
    document.querySelectorAll(".currency-input").forEach((input) => {
        input.addEventListener("input", function (e) {
            const cursorPosition = e.target.selectionStart;
            const oldLength = e.target.value.length;

            e.target.value = formatCurrency(e.target.value);

            // Maintain cursor position
            const newLength = e.target.value.length;
            const diff = newLength - oldLength;
            e.target.setSelectionRange(
                cursorPosition + diff,
                cursorPosition + diff
            );
        });

        // Format on blur for better UX
        input.addEventListener("blur", function (e) {
            e.target.value = formatCurrency(e.target.value);
        });
    });

    // Date validation
    const createDate = document.querySelector('input[name="create_date"]');
    const submitDate = document.querySelector('input[name="submit_date"]');

    if (submitDate) {
        submitDate.addEventListener("change", function () {
            if (createDate.value && submitDate.value) {
                if (new Date(submitDate.value) < new Date(createDate.value)) {
                    submitDate.setCustomValidity(
                        "Submit date cannot be earlier than create date"
                    );
                } else {
                    submitDate.setCustomValidity("");
                }
            }
        });
    }
}

function initializeCurrencyInputs() {
    document.querySelectorAll(".currency-input").forEach((input) => {
        if (input.value) {
            input.value = formatCurrency(input.value);
        }
    });
}

function formatCurrency(value) {
    // Remove all non-numeric characters except comma and period
    let cleanValue = value.replace(/[^\d,.-]/g, "");

    // Replace comma with period for parsing
    cleanValue = cleanValue.replace(",", ".");

    // Convert to number
    let number = parseFloat(cleanValue);

    // Check if valid number
    if (isNaN(number)) return "";

    // Limit to reasonable amount (999 trillion)
    if (number > 999999999999999) {
        number = 999999999999999;
    }

    // Format as Indonesian Rupiah without decimal places
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(number);
}

// Perbaikan fungsi calculateTaxFields
function calculateTaxFields() {
    const amountInput = document.querySelector('input[name="amount"]');
    if (!amountInput) return;

    // Parse currency - remove Rp, dots, and spaces
    const cleanAmount = amountInput.value.replace(/[Rp.\s]/g, "");
    const amount = parseFloat(cleanAmount) || 0;

    // Calculate taxes
    const vat11 = amount * 0.11;
    const pph2 = amount * 0.02;
    const paymentVat = amount + vat11 - pph2;

    // Update fields
    const vat11Input = document.querySelector('input[name="vat_11"]');
    const pph2Input = document.querySelector('input[name="pph_2"]');
    const paymentVatInput = document.querySelector('input[name="payment_vat"]');

    if (vat11Input) vat11Input.value = formatCurrency(vat11.toString());
    if (pph2Input) pph2Input.value = formatCurrency(pph2.toString());
    if (paymentVatInput)
        paymentVatInput.value = formatCurrency(paymentVat.toString());
}

function handleFormSubmit(e) {
    e.preventDefault();

    // Show progress
    showProgress();

    // Disable submit button
    const submitBtn = document.getElementById("submit-btn");
    const originalContent = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML =
        '<svg class="w-4 h-4 animate-spin inline-block mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span>Submitting...</span>';

    // Get form and create FormData
    const form = e.target;
    const formData = new FormData(form);

    // Get CSRF token
    const csrfToken = document
        .querySelector('meta[name="_token"]')
        ?.getAttribute("content");

    if (!csrfToken) {
        showError("CSRF token not found. Please refresh the page.");
        hideProgress();
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalContent;
        return;
    }

    // Submit form with proper headers
    fetch(form.action, {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
        credentials: "same-origin",
    })
        .then((response) => {
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Check content type
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                return response.json();
            } else {
                // If not JSON, it might be an HTML error page
                return response.text().then((text) => {
                    console.error("Non-JSON response:", text);
                    throw new Error(
                        "Server returned non-JSON response. This usually means an error occurred."
                    );
                });
            }
        })
        .then((data) => {
            if (data.success) {
                showSuccess(data.message || "Form submitted successfully!");
                clearDraft();
                isDirty = false;

                // Redirect after 2 seconds if URL provided
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                }
            } else {
                showError(
                    data.message ||
                        "An error occurred while submitting the form."
                );
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showError(
                error.message ||
                    "Network error. Please check your connection and try again."
            );
        })
        .finally(() => {
            hideProgress();
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalContent;
        });
}

function showProgress() {
    const container = document.getElementById("progress-container");
    const bar = document.getElementById("progress-bar");
    const text = document.getElementById("progress-text");

    container.classList.remove("hidden");

    let progress = 0;
    const interval = setInterval(() => {
        progress += 10;
        if (progress > 90) {
            clearInterval(interval);
        }
        bar.style.width = progress + "%";
        text.textContent = progress;
    }, 200);
}

function hideProgress() {
    const container = document.getElementById("progress-container");
    const bar = document.getElementById("progress-bar");
    const text = document.getElementById("progress-text");

    bar.style.width = "100%";
    text.textContent = "100";

    setTimeout(() => {
        container.classList.add("hidden");
        bar.style.width = "0%";
        text.textContent = "0";
    }, 500);
}

// Update showSuccess to accept custom message
function showSuccess(message = "Form submitted successfully!") {
    const notification = document.getElementById("success-notification");
    const messageEl = notification.querySelector("span.text-green-800");

    if (messageEl) {
        messageEl.textContent = message;
    }

    notification.classList.remove("hidden");

    setTimeout(() => {
        notification.classList.add("hidden");
    }, 5000);
}
function showError(message) {
    const notification = document.getElementById("error-notification");
    const messageEl = document.getElementById("error-message");

    messageEl.textContent = message;
    notification.classList.remove("hidden");
}

function hideError() {
    const notification = document.getElementById("error-notification");
    notification.classList.add("hidden");
}

function saveDraft() {
    const form = document.getElementById("payment-form");
    const formData = new FormData(form);
    const data = {};

    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }

    localStorage.setItem("payment-form-draft", JSON.stringify(data));

    // Show temporary notification
    const notification = document.createElement("div");
    notification.className =
        "fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg";
    notification.textContent = "Draft saved!";
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 2000);
}

function loadDraft() {
    const draft = localStorage.getItem("payment-form-draft");
    if (draft) {
        try {
            const data = JSON.parse(draft);
            const form = document.getElementById("payment-form");

            Object.keys(data).forEach((key) => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input && input.type !== "hidden") {
                    input.value = data[key];
                }
            });

            // Recalculate tax fields if amount exists
            if (data.amount) {
                calculateTaxFields();
            }
        } catch (e) {
            console.error("Error loading draft:", e);
        }
    }
}

function clearDraft() {
    localStorage.removeItem("payment-form-draft");
}

function startAutoSave() {
    setInterval(() => {
        if (isDirty) {
            saveDraft();
            isDirty = false;
        }
    }, 2000);
}

function updateLastUpdated() {
    const element = document.getElementById("last-updated");
    if (element) {
        element.textContent = new Date().toLocaleString("en-US", {
            month: "short",
            day: "numeric",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
    }
}

function resetForm() {
    if (
        confirm(
            "Are you sure you want to reset the form? All unsaved data will be lost."
        )
    ) {
        const form = document.getElementById("payment-form");
        form.reset();

        // Clear calculated fields
        document.querySelector('input[name="vat_11"]').value = "";
        document.querySelector('input[name="pph_2"]').value = "";
        document.querySelector('input[name="payment_vat"]').value = "";

        // Clear draft
        clearDraft();
        isDirty = false;

        // Reset year to current
        const yearSelect = document.querySelector('select[name="year"]');
        if (yearSelect) {
            yearSelect.value = new Date().getFullYear().toString();
        }
    }
}

// Prevent accidental navigation when form is dirty
window.addEventListener("beforeunload", function (e) {
    if (isDirty) {
        e.preventDefault();
        e.returnValue = "";
    }
});
