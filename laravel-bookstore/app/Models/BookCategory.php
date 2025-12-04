<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookCategory extends Model
{
    use HasFactory;

    protected $table = 'book_cate';
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class, 'book_category_id');
    }
}
