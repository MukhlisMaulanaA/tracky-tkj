<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderItem extends Model
{
  protected $table = 'purchase_order_items';
  protected $primaryKey = 'id_item';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'id_item',
    'po_id',
    'description',
    'quantity',
    'unit',
    'unit_price',
    'subtotal',
  ];

  public function purchaseOrder(): BelongsTo
  {
    return $this->belongsTo(PurchaseOrder::class, 'po_id', 'id_po');
  }
}
