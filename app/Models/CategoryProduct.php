<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'image',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product_poducts');
    }
}
