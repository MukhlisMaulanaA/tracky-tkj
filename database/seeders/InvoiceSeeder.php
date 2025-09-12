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
        'id_invoice' => 'INV25A001',
        'id_project' => 'P25A005',
        'year' => 2025,
        'create_date' => Carbon::parse('2025-01-01'),
        'submit_date' => Carbon::parse('2025-01-01'),
        'duration' => 12,
        'po_number' => 'PO.YSI-ZTE-011016',
        'invoice_number' => '001/P/TKJ/I/2025',
        'remarks' => 'DONE PAYMENT',
        'notes' => 'Done Payment 100%',
        'amount' => 56000000,
        'vat' => 6160000,
        'pph' => 1120000,
        'denda' => null,
        'payment_vat' => 62160000,
        'real_payment' => 54880000,
        'paid_amount' => 62160000,
        'date_payment' => Carbon::parse('2025-01-17'),
      ],
      [
        'id_invoice' => 'INV25B002',
        'id_project' => 'P25B022',
        'year' => 2025,
        'create_date' => Carbon::parse('2025-01-25'),
        'submit_date' => Carbon::parse('2025-01-25'),
        'duration' => 10,
        'po_number' => '135-XI-TKJ',
        'invoice_number' => '002/TKJ/I/2025',
        'remarks' => 'PROCES PAYMENT',
        'notes' => 'Proces Payment 50%',
        'amount' => 26190000,
        'vat' => null,
        'pph' => null,
        'denda' => null,
        'payment_vat' => 26190000,
        'real_payment' => 26190000,
        'paid_amount' => 10000000,
        'date_payment' => Carbon::parse('2025-05-02'),
      ],
      [
        'id_invoice' => 'INV25B001',
        'id_project' => 'P25C013',
        'year' => 2025,
        'create_date' => Carbon::parse('2025-01-30'),
        'submit_date' => Carbon::parse('2025-01-30'),
        'duration' => 0,
        'po_number' => 'SPK.NO.SUM001/ABG_TKJ/SACME/1/2025',
        'invoice_number' => '002/P/TKJ/I/2025',
        'remarks' => 'WAITING PAYMENT',
        'notes' => 'Waiting Payment -30%',
        'amount' => 23075100,
        'vat' => 2538261,
        'pph' => 461502,
        'denda' => null,
        'payment_vat' => 25613361,
        'real_payment' => 22613598,
        'paid_amount' => 22613598,
        'date_payment' => null,
      ],
    ];

    foreach ($data as $invoice) {
      Invoice::create($invoice);
    }
  }
}
