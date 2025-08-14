<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = [
    'id_project',
    'customer_name',
    'location',
    'submit_date',
    'briefing_date',
    'project_name',
    'deadline',
    'remarks',
    'notes',
  ];

  // Non-incrementing primary key (optional)
  public $incrementing = false;
  // protected $primaryKey = 'id_project';
  protected $keyType = 'string';
}
