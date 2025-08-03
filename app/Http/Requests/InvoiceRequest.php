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
      'id_project' => 'required|exists:projects,id_project',
      'year' => 'required|digits:4',
      'create_date' => 'nullable|date',
      'submit_date' => 'nullable|date',
      'date_payment' => 'nullable|date',
      'po_number' => 'nullable|string',
      'invoice_number' => 'nullable|string',
      'remarks' => 'string',
      'notes' => 'nullable|string',
      'amount' => 'required|string', // masih dalam format ribuan
      'pph_percent' => 'required|numeric|min:0|max:100',
      'denda' => 'nullable|string',
    ];
  }

  // public function messages()
  // {
  //   return [
  //     'sequential_number.required' => 'Sequential number is required',
  //     'year.required' => 'Year is required',
  //     'year.digits' => 'Year must be 4 digits',
  //     'project_name.required' => 'Project name is required',
  //     'customer_name.required' => 'Customer name is required',
  //     'amount.required' => 'Amount is required',
  //     'submit_date.after_or_equal' => 'Submit date cannot be earlier than create date',
  //     'po_number.regex' => 'PO number must follow format: PO-YYYY-XXXX',
  //     'invoice_number.regex' => 'Invoice number must follow format: INV-YYYY-XXXX',
  //   ];
  // }
}