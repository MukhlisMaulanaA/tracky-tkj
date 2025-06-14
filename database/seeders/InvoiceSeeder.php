<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvoiceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run()
  {
    $data = [
      [
        'id_project' => 'P25A001',
        'year' => 2025,
        'create_date' => Carbon::parse('2025-01-01'),
        'submit_date' => Carbon::parse('2025-01-01'),
        'po_number' => 'PO.YSI-ZTE-011016',
        'invoice_number' => '001/P/TKJ/I/2025',
        'remark' => 'DONE PAYMENT',
        'amount' => 56000000,
        'vat_11' => 6160000,
        'pph_2' => 1120000,
        'denda' => null,
        'payment_vat' => 62160000,
        'real_payment' => 54880000,
        'date_payment' => Carbon::parse('2025-01-17'),
      ],
      [
        'id_project' => 'P25B002',
        'year' => 2025,
        'create_date' => Carbon::parse('2025-01-25'),
        'submit_date' => Carbon::parse('2025-01-25'),
        'po_number' => '135-XI-TKJ',
        'invoice_number' => '002/TKJ/I/2025',
        'remark' => 'DONE PAYMENT 30%',
        'amount' => 26190000,
        'vat_11' => null,
        'pph_2' => null,
        'denda' => null,
        'payment_vat' => 26190000,
        'real_payment' => 26190000,
        'date_payment' => Carbon::parse('2025-05-02'),
      ],
      [
        'id_project' => 'P25C003',
        'year' => 2025,
        'create_date' => Carbon::parse('2025-01-30'),
        'submit_date' => Carbon::parse('2025-01-30'),
        'po_number' => 'SPK.NO.SUM001/ABG_TKJ/SACME/1/2025',
        'invoice_number' => '002/P/TKJ/I/2025',
        'remark' => 'WAITING PAYMENT 5%',
        'amount' => 23075100,
        'vat_11' => 2538261,
        'pph_2' => 461502,
        'denda' => null,
        'payment_vat' => 25613361,
        'real_payment' => 22613598,
        'date_payment' => null,
      ],
    ];

    foreach ($data as $invoice) {
      Invoice::create($invoice);
    }
  }
}
