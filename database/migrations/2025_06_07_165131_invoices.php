<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('invoices', function (Blueprint $table) {
      $table->id();
      $table->string('sequential_number');
      $table->string('year', 4);
      $table->string('project_name');
      $table->date('create_date')->nullable();
      $table->date('submit_date')->nullable();
      $table->date('date_payment')->nullable();
      $table->string('po_number')->nullable();
      $table->string('invoice_number')->nullable();
      $table->text('remark')->nullable();
      $table->string('customer_name');
      $table->decimal('amount', 15, 2);
      $table->decimal('vat_11', 15, 2)->nullable();
      $table->decimal('pph_2', 15, 2)->nullable();
      $table->decimal('fine', 15, 2)->nullable();
      $table->decimal('payment_vat', 15, 2)->nullable();
      $table->decimal('real_payment', 15, 2)->nullable();
      $table->timestamps();

      // Indexes for better performance
      $table->index('sequential_number');
      $table->index('year');
      $table->index('customer_name');
      $table->index('created_at');
    });
  }

  public function down()
  {
    Schema::dropIfExists('invoices');
  }
};