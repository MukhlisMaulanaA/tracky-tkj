<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    'notes'
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($payment) {
      if (!$payment->id_payment) {
        $year = date('y');
        $monthNum = (int) date('n'); // 1-12
        $monthLetter = chr(64 + $monthNum); // 1=A, 2=B, dst.

        // ambil last payment bulan ini
        $lastPayment = self::whereYear('created_at', date('Y'))
          ->whereMonth('created_at', $monthNum)
          ->orderBy('id_payment', 'desc')
          ->first();

        if ($lastPayment) {
          $lastNumber = (int) substr($lastPayment->id_payment, -3);
          $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
          $newNumber = '001';
        }

        $payment->id_payment = 'PAY' . $year . $monthLetter . $newNumber;
      }
    });
  }


  public function getRouteKeyName()
  {
    return 'id_payment';
  }

  public function invoice()
  {
    return $this->belongsTo(Invoice::class, 'id_invoice', 'id_invoice');
  }

}
