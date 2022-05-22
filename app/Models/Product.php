<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'cost',
        'price',
        'unit_id',
        'type_id'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'product_transaction');
    }
}
