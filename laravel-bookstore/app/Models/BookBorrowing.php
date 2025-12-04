<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookBorrowing extends Model
{
    use HasFactory;

    protected $table = 'books_borrow';

    protected $fillable = [
        'book_id',
        'user_id',
        'issue_date',
        'due_date',
        'return_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue()
    {
        return $this->status === 'issued' && $this->due_date < now();
    }
}
