<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['total_amount', 'status', 'sales_id'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')->withPivot('quantity');
    }
}
