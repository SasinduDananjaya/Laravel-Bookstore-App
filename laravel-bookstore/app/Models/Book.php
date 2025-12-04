<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'price',
        'stock',
        'book_category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }

    public function borrowings()
    {
        return $this->hasMany(BookBorrowing::class);
    }

    public function isAvailable()
    {
        return $this->stock > 0;
    }

    public function decrementStock()
    {
        if ($this->stock > 0) {
            $this->decrement('stock');
            return true;
        }
        return false;
    }

    public function incrementStock()
    {
        $this->increment('stock');
        return true;
    }
}
