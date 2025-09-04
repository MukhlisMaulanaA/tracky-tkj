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
    'vat',
    'pph',
    'denda',
    'payment_vat',
    'real_payment',
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
    return $this->hasMany(Payment::class);
  }

}