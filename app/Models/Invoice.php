<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  protected $fillable = [
    'no',
    'tahun',
    'project',
    'create_tanggal',
    'submit_tanggal',
    'no_po',
    'no_invoice',
    'remark',
    'costumer',
    'amount',
    'vat_11',
    'pph_2',
    'denda',
    'payment_vat',
    'real_payment',
    'date_payment',
  ];

  // Perhitungan otomatis jika diperlukan sebagai accessor:
  public function getVat11Attribute()
  {
    return $this->amount * 0.11;
  }

  public function getPph2Attribute()
  {
    return $this->amount * 0.02;
  }

  public function getPaymentVatAttribute()
  {
    return $this->amount + $this->vat_11;
  }

  public function getRealPaymentAttribute()
  {
    return $this->amount - $this->pph_2;
  }
}
