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
    Schema::create('payments', function (Blueprint $table) {
      $table->string('id_payment', 20)->primary(); // Primary Key string
      $table->string('id_invoice', 20);
      $table->foreign('id_invoice')->references('id_invoice')->on('invoices')->onDelete('cascade');
      $table->decimal('amount', 15, 2);       // jumlah yang dibayar
      $table->timestamp('payment_date');           // tanggal pembayaran
      $table->string('pay_method')->nullable();   // metode pembayaran (Transfer, Cash, Giro, dll.)
      $table->string('reference')->nullable(); // nomor referensi pembayaran (No Transfer, Giro, dll.)
      $table->text('notes')->nullable();      // catatan tambahan
      $table->timestamps();
    });

  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('payments');
  }
};
