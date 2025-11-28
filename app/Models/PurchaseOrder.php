<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $primaryKey = 'id_po';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_po',
        'po_number',
        'project_id',
        'created_date',
        'total_value',
        'status',
        'document',
        'note',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'po_id', 'id_po');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id_project');
    }
}
