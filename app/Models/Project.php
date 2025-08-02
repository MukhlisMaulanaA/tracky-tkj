<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = [
    'id_project',
    'customer_name',
    'tanggal_submit',
    'tanggal_briefing',
    'project_name',
    'nomor_po',
    'deadline',
    'remarks',
    'notes',
  ];

  // Non-incrementing primary key (optional)
  public $incrementing = false;
  // protected $primaryKey = 'id_project';
  protected $keyType = 'string';
}
