<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
  use HasFactory;

  protected $primaryKey = 'id_invoice';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'id_invoice',
    'id_project',
    'year',
    'create_date',
    'submit_date',
    'date_payment',
    'duration',
    'po_number',
    'invoice_number',
    'remarks',
    'status',
    'notes',
    'amount',
    'progress',
    'vat',
    'pph',
    'denda',
    'payment_vat',
    'real_payment',
    'paid_amount',
  ];

  public function getRouteKeyName()
  {
    return 'id_invoice';
  }

  public function project()
  {
    return $this->belongsTo(Project::class, 'id_project', 'id_project');
  }

  public function payments()
  {
    return $this->hasMany(Payment::class, 'id_invoice', 'id_invoice');
  }

  public function recalcPaymentStatus()
  {
    // Hitung ulang total pembayaran
    $this->paid_amount = $this->payments()->sum('amount');

    // Hitung progress %
    $this->progress = $this->payment_vat > 0
      ? min(round(($this->paid_amount / $this->payment_vat) * 100), 100)
      : 0;

    // Tentukan remarks & tanggal pembayaran
    if ($this->paid_amount == 0) {
      $this->remarks = 'WAITING PAYMENT';
      $this->date_payment = null;
    } elseif ($this->paid_amount < $this->payment_vat) {
      $this->remarks = 'PROCES PAYMENT';
      $this->date_payment = now(); // atau pakai last payment_date
    } else {
      $this->remarks = 'DONE PAYMENT';
      $this->date_payment = now(); // invoice lunas
    }

    // 🔹 Hitung durasi dari submit_date ke date_payment
    if ($this->submit_date && $this->date_payment) {
      $this->duration = Carbon::parse($this->submit_date)
        ->diffInDays(Carbon::parse($this->date_payment));
    } else {
      $this->duration = null; // belum bisa dihitung
    }

    $this->save();
  }


}