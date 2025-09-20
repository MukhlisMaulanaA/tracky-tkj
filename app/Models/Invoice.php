<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    $this->paid_amount = $this->payments()->sum('amount');

    $this->progress = $this->payment_vat > 0
      ? min(round(($this->paid_amount / $this->payment_vat) * 100), 100)
      : 0;

    if ($this->paid_amount == 0) {
      $this->remarks = 'WAITING PAYMENT';
      $this->date_payment = null;
    } elseif ($this->paid_amount < $this->payment_vat) {
      $this->remarks = 'PROCES PAYMENT';
      $this->date_payment = now(); // atau last payment date
    } else {
      $this->remarks = 'DONE PAYMENT';
      $this->date_payment = now();
    }

    $this->save();
  }

}