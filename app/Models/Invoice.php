<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  use HasFactory;

  protected $fillable = [
    'id_project',
    'year',
    'create_date',
    'submit_date',
    'date_payment',
    'po_number',
    'invoice_number',
    'remark',
    'notes',
    'amount',
    'vat',
    'pph',
    'denda',
    'payment_vat',
    'real_payment',
  ];

  public function project()
  {
    return $this->belongsTo(Project::class, 'id_project', 'id_project');
  }
}