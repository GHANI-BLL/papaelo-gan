<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'isbn',
        'author_id',
        'category_id',
        'description',
        'total_copies',
        'available_copies',
        'publisher',
        'published_year',
        'price',
    ];

    /**
     * Relasi ke Author
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Relasi ke Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke BorrowRecord
     */
    public function borrowRecords()
    {
        return $this->hasMany(BorrowRecord::class);
    }
}
