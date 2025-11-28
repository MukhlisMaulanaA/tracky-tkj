<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('purchase_order_items', function (Blueprint $table) {
      $table->string('id_item', 20)->primary();
      $table->string('po_id', 20);
      $table->string('description');
      $table->integer('quantity');
      $table->string('unit');
      $table->double('unit_price');
      $table->double('subtotal');
      $table->timestamps();

      $table->foreign('po_id')
        ->references('id_po')
        ->on('purchase_orders')
        ->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('purchase_order_items');
  }
};
