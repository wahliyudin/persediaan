<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_IN = 'in';
    const STATUS_OUT = 'out';

    protected $fillable = [
        'product_id',
        'invoice',
        'tanggal',
        'jumlah',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
