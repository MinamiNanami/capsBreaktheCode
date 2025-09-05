<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['customer_name', 'service', 'order_method', 'table_number', 'payment_method', 'total', 'discount'];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

}
