<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->id(); // Auto increment id sebagai primary key
      $table->string('id_project', 20)->unique(); // Format: PYYYYMXXX
      $table->string('customer_name');
      $table->string('location');
      $table->date('tanggal_submit');
      $table->date('tanggal_briefing');
      $table->string('project_name');
      $table->date('deadline')->nullable();
      $table->enum('remarks', ['Approved', 'On Progress', 'Pending', 'Cancel']);
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('projects');
  }
};
