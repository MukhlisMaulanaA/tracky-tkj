<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

  protected $primaryKey = 'id_project';
  public $incrementing = false;
  protected $keyType = 'string';

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

  public function getRouteKeyName()
  {
    return 'id_project';
  }

  public function invoice()
  {
    return $this->hasOne(Invoice::class, 'id_project', 'id_project');
  }
}
