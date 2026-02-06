<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    // protected $fillable = ['name', 'image', 'description','guarantee', 'mrp', 'sellprice', 'stock', 'sku', 'producttype_id', 'subcategory_id', 'category_id', 'brand_id', 'status'];
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'description',
        'status',
        'slug',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subcategory2()
    {
        return $this->belongsTo(SubCategory2::class);
    }
}
