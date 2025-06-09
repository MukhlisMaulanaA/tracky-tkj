<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequential_number',
        'year',
        'project_name',
        'create_date',
        'submit_date',
        'date_payment',
        'po_number',
        'invoice_number',
        'remark',
        'customer_name',
        'amount',
        'vat_11',
        'pph_2',
        'fine',
        'payment_vat',
        'real_payment',
    ];

    protected $casts = [
        'create_date' => 'date',
        'submit_date' => 'date',
        'date_payment' => 'date',
        'amount' => 'decimal:2',
        'vat_11' => 'decimal:2',
        'pph_2' => 'decimal:2',
        'fine' => 'decimal:2',
        'payment_vat' => 'decimal:2',
        'real_payment' => 'decimal:2',
    ];

    // Accessors for formatted currency display
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getFormattedVat11Attribute()
    {
        return 'Rp ' . number_format($this->vat_11, 0, ',', '.');
    }

    public function getFormattedPph2Attribute()
    {
        return 'Rp ' . number_format($this->pph_2, 0, ',', '.');
    }

    public function getFormattedFineAttribute()
    {
        return 'Rp ' . number_format($this->fine, 0, ',', '.');
    }

    public function getFormattedPaymentVatAttribute()
    {
        return 'Rp ' . number_format($this->payment_vat, 0, ',', '.');
    }

    public function getFormattedRealPaymentAttribute()
    {
        return 'Rp ' . number_format($this->real_payment, 0, ',', '.');
    }
}