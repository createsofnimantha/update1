<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Allow mass assignment for name column
    protected $fillable = ['name'];

    // Relationship: A category has many subcategories
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    // Relationship: A category has many books (a category can have many books)
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
