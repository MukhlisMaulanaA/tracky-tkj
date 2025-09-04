<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  /** @use HasFactory<\Database\Factories\PaymentFactory> */
  use HasFactory;

  protected $primaryKey = 'id_payment';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'id_invoice',
    'amount',
    'payment_date',
    'pay_method',
    'reference',
    'note'
  ];

  public function getRouteKeyName()
  {
    return 'id_payment';
  }

  public function invoice()
  {
    return $this->belongsTo(Invoice::class);
  }

}
