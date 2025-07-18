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
        'id_project' => 'P25A005',
        'customer_name' => 'PT Alpha Teknologi',
        'tanggal_submit' => '2025-01-05',
        'tanggal_breifing' => '2025-01-07',
        'project_name' => 'Development Internal App',
        'nomor_po' => 'PO-001/AT/2025',
        'deadline' => '2025-03-15',
        'remarks' => 'Yes',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'id_project' => 'P25B022',
        'customer_name' => 'CV Beta Jaya',
        'tanggal_submit' => '2025-02-10',
        'tanggal_breifing' => '2025-02-12',
        'project_name' => 'Website Company Profile',
        'nomor_po' => 'PO-002/BJ/2025',
        'deadline' => '2025-04-20',
        'remarks' => 'Pending',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'id_project' => 'P25C013',
        'customer_name' => 'PT Gamma Nusantara',
        'tanggal_submit' => '2025-03-15',
        'tanggal_breifing' => '2025-03-18',
        'project_name' => 'E-Commerce Platform',
        'nomor_po' => 'PO-003/GN/2025',
        'deadline' => '2025-06-01',
        'remarks' => 'No',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    DB::table('projects')->insert($projects);
  }
}
