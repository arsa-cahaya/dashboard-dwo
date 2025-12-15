<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactPurchasing extends Model
{
    use HasFactory;
    protected $table = 'FactPurchasing';
    protected $primaryKey = 'PurchasingKey';
    public $timestamps = false;

    protected $fillable = [
        'TimeKey',
        'ProductKey',
        'VendorKey',
        'ShipMethodKey',
        'OrderQty',
        'UnitPrice',
        'LineTotal'
    ];

    public function vendor()
    {
        return $this->belongsTo(DimVendor::class, 'VendorKey');
    }
}
