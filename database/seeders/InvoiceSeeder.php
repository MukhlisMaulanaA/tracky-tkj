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
        'no' => 1,
        'tahun' => 2025,
        'project' => 'DCI',
        'create_tanggal' => Carbon::parse('2025-01-01'),
        'submit_tanggal' => Carbon::parse('2025-01-01'),
        'no_po' => 'PO.YSI-ZTE-011016',
        'no_invoice' => '001/P/TKJ/I/2025',
        'remark' => 'DONE PAYMENT',
        'costumer' => 'PT.YPPT SOLUTIONS',
        'amount' => 56000000,
        'vat_11' => 6160000,
        'pph_2' => 1120000,
        'denda' => null,
        'payment_vat' => 62160000,
        'real_payment' => 54880000,
        'date_payment' => Carbon::parse('2025-01-17'),
      ],
      [
        'no' => 2,
        'tahun' => 2025,
        'project' => 'PIK',
        'create_tanggal' => Carbon::parse('2025-01-25'),
        'submit_tanggal' => Carbon::parse('2025-01-25'),
        'no_po' => '135-XI-TKJ',
        'no_invoice' => '002/TKJ/I/2025',
        'remark' => 'DONE PAYMENT 30%',
        'costumer' => 'PT.DAENJO',
        'amount' => 26190000,
        'vat_11' => null,
        'pph_2' => null,
        'denda' => null,
        'payment_vat' => 26190000,
        'real_payment' => 26190000,
        'date_payment' => Carbon::parse('2025-05-02'),
      ],
      [
        'no' => 3,
        'tahun' => 2025,
        'project' => 'LAMPUNG',
        'create_tanggal' => Carbon::parse('2025-01-30'),
        'submit_tanggal' => Carbon::parse('2025-01-30'),
        'no_po' => 'SPK.NO.SUM001/ABG_TKJ/SACME/1/2025',
        'no_invoice' => '002/P/TKJ/I/2025',
        'remark' => 'WAITING PAYMENT 5%',
        'costumer' => 'PT.ANANTA BANGUN GRAHA',
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
