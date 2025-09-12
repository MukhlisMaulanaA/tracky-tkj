<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('invoices', function (Blueprint $table) {
      $table->string('id_invoice', 20)->primary(); // Primary Key string
      $table->string('id_project', 20);
      $table->foreign('id_project')
        ->references('id_project')
        ->on('projects')
        ->onDelete('cascade');

      $table->string('year', 4);
      $table->date('create_date')->nullable();
      $table->date('submit_date')->nullable();
      $table->date('date_payment')->nullable();
      $table->unsignedInteger('duration')->nullable();
      $table->string('po_number')->nullable();
      $table->string('invoice_number')->nullable();
      $table->enum('remarks', ['DONE PAYMENT', 'WAITING PAYMENT', 'PROCES PAYMENT']);
      $table->unsignedTinyInteger('progress')->nullable(); // 0–100
      $table->text('notes')->nullable();
      $table->decimal('amount', 15, 2);
      $table->decimal('vat', 15, 2)->nullable();
      $table->decimal('pph', 15, 2)->nullable();
      $table->decimal('denda', 15, 2)->nullable();
      $table->decimal('payment_vat', 15, 2)->nullable();
      $table->decimal('real_payment', 15, 2)->nullable();
      $table->decimal('paid_amount', 15, 2)->nullable();
      $table->timestamps();

      $table->index('year');
      $table->index('created_at');
    });
  }

  public function down()
  {
    Schema::dropIfExists('invoices');
  }
};