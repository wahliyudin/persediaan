<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const TYPE_IN = 'in';
    const TYPE_OUT = 'out';
    const TYPE_ORDER = 'order';

    protected $fillable = [
        'invoice',
        'date',
        'type'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_transaction');
    }
}
