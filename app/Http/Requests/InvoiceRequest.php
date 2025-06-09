<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'sequential_number' => 'required|string|max:255',
      'year' => 'required|digits:4',
      'project_name' => 'required|string|max:255',
      'create_date' => 'nullable|date',
      'submit_date' => 'nullable|date|after_or_equal:create_date',
      'date_payment' => 'nullable|date',
      'po_number' => 'nullable|string|regex:/^PO-\d{4}-\d+$/',
      'invoice_number' => 'nullable|string|regex:/^INV-\d{4}-\d+$/',
      'remark' => 'nullable|string',
      'customer_name' => 'required|string|max:255',
      'amount' => 'required|string',
      'vat_11' => 'nullable|string',
      'pph_2' => 'nullable|string',
      'fine' => 'nullable|string',
      'payment_vat' => 'nullable|string',
      'real_payment' => 'nullable|string',
    ];
  }

  public function messages()
  {
    return [
      'sequential_number.required' => 'Sequential number is required',
      'year.required' => 'Year is required',
      'year.digits' => 'Year must be 4 digits',
      'project_name.required' => 'Project name is required',
      'customer_name.required' => 'Customer name is required',
      'amount.required' => 'Amount is required',
      'submit_date.after_or_equal' => 'Submit date cannot be earlier than create date',
      'po_number.regex' => 'PO number must follow format: PO-YYYY-XXXX',
      'invoice_number.regex' => 'Invoice number must follow format: INV-YYYY-XXXX',
    ];
  }
}