<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{ 
    // protected $table="category";
    protected $fillable = ['name', 'image', 'status','slug'];

public function subcategory()
{
    return $this->belongsTo(Subcategory::class, 'id');
}
 public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories()
{
    return $this->hasMany(SubCategory::class, 'category_id', 'id');
}



}
