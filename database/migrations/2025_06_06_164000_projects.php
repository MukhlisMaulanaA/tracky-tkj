<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->string('id_project', 20)->primary(); // Primary Key string
      $table->string('customer_name');
      $table->string('location');
      $table->date('submit_date');
      $table->date('briefing_date');
      $table->string('project_name');
      $table->date('deadline')->nullable();
      $table->enum('remarks', ['APPROVED', 'PROGRESS', 'PENDING', 'CANCEL']);
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('projects');
  }
};
