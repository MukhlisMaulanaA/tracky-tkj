<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('purchase_orders', function (Blueprint $table) {
      $table->string('id_po', 20)->primary();
      $table->string('po_number');
      $table->string('project_id', 20);
      $table->date('created_date');
      $table->double('total_value');
      $table->enum('status', ['Draft', 'Approved', 'In Progress', 'Completed'])->default('Draft');
      $table->string('document')->nullable();
      $table->text('note')->nullable();
      $table->timestamps();

      $table->foreign('project_id')->references('id_project')->on('projects')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('purchase_orders');
  }
};
