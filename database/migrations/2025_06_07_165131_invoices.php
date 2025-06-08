<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('invoices', function (Blueprint $table) {
      $table->id();
      $table->integer('no');
      $table->year('tahun');
      $table->string('project');
      $table->date('create_tanggal')->nullable();
      $table->date('submit_tanggal')->nullable();
      $table->string('no_po');
      $table->string('no_invoice');
      $table->string('remark')->nullable();
      $table->string('costumer');
      $table->decimal('amount', 20, 2)->default(0);
      $table->decimal('vat_11', 20, 2)->nullable(); // PPN
      $table->decimal('pph_2', 20, 2)->nullable();  // PPH
      $table->decimal('denda', 20, 2)->nullable();
      $table->decimal('payment_vat', 20, 2)->nullable(); // Payment Net
      $table->decimal('real_payment', 20, 2)->nullable(); // Real Payment
      $table->date('date_payment')->nullable();
      $table->timestamps();
    });

  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('invoices');
  }
};
