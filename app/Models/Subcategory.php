<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    // Allow mass assignment for name and category_id
    protected $fillable = ['name', 'category_id'];

    // Relationship: A subcategory belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship: A subcategory has many books
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
