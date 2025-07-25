<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

protected $fillable = [
    'title',
    'author',
    'published_year',
    'user_id',
    'category_id', // ➕ Add this
    'subcategory_id' // ➕ Add this
];

    public function coverImage()
    {
        return $this->hasOne(CoverImage::class);
    }

    // ✅ Add relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
{
    return $this->belongsTo(Category::class);
}

public function subcategory()
{
    return $this->belongsTo(Subcategory::class);
}

}
