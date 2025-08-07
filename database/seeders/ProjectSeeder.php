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
        'location' => 'Aceh',
        'tanggal_submit' => '2025-01-05',
        'tanggal_briefing' => '2025-01-07',
        'project_name' => 'Development Internal App',
        'deadline' => '2025-03-15',
        'remarks' => 'Approved',
        'notes' => 'Lorem Ipsum Dolor Sit Amet #mukhlis',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'id_project' => 'P25B022',
        'customer_name' => 'CV Beta Jaya',
        'location' => 'Jakarta Pusat',
        'tanggal_submit' => '2025-02-10',
        'tanggal_briefing' => '2025-02-12',
        'project_name' => 'Website Company Profile',
        'deadline' => '2025-04-20',
        'remarks' => 'On Progress',
        'notes' => 'Lorem Ipsum Dolor Sit Amet #mukhlis',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'id_project' => 'P25C013',
        'customer_name' => 'PT Gamma Nusantara',
        'location' => 'Jakarta Barat',
        'tanggal_submit' => '2025-03-15',
        'tanggal_briefing' => '2025-03-18',
        'project_name' => 'E-Commerce Platform',
        'deadline' => '2025-06-01',
        'remarks' => 'Cancel',
        'notes' => 'Lorem Ipsum Dolor Sit Amet #mukhlis',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'id_project' => 'P25E001',
        'customer_name' => 'PT Datindo Infonet Prima',
        'location' => 'Bandung',
        'tanggal_submit' => '2025-03-15',
        'tanggal_briefing' => '2025-03-18',
        'project_name' => 'Network Installation',
        'deadline' => '2025-06-01',
        'remarks' => 'Approved',
        'notes' => 'Lorem Ipsum Dolor Sit Amet #mukhlis',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    DB::table('projects')->insert($projects);
  }
}
