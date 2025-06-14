<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
  public function run()
  {
    $projects = [
      [
        'id_project' => 'P24A001',
        'customer_name' => 'PT Alpha Teknologi',
        'tanggal_submit' => '2024-01-05',
        'tanggal_breifing' => '2024-01-07',
        'project_name' => 'Development Internal App',
        'nomor_po' => 'PO-001/AT/2024',
        'deadline' => '2024-03-15',
        'remarks' => 'Yes',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'id_project' => 'P24B002',
        'customer_name' => 'CV Beta Jaya',
        'tanggal_submit' => '2024-02-10',
        'tanggal_breifing' => '2024-02-12',
        'project_name' => 'Website Company Profile',
        'nomor_po' => 'PO-002/BJ/2024',
        'deadline' => '2024-04-20',
        'remarks' => 'Pending',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'id_project' => 'P24C003',
        'customer_name' => 'PT Gamma Nusantara',
        'tanggal_submit' => '2024-03-15',
        'tanggal_breifing' => '2024-03-18',
        'project_name' => 'E-Commerce Platform',
        'nomor_po' => 'PO-003/GN/2024',
        'deadline' => '2024-06-01',
        'remarks' => 'No',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    DB::table('projects')->insert($projects);
  }
}
