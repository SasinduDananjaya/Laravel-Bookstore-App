<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Mastering IT in Sri Lanka',
                'author' => 'Hiran Samarasekara',
                'price' => 14.99,
                'stock' => 10,
                'book_category_id' => 1
            ],
            [
                'title' => 'ICT for Advanced Level',
                'author' => 'Nuwan Perera',
                'price' => 9.99,
                'stock' => 20,
                'book_category_id' => 1
            ],

            // Psychology
            [
                'title' => 'Psychology of Human Behavior',
                'author' => 'Dr. Pushpa Fonseka',
                'price' => 13.50,
                'stock' => 15,
                'book_category_id' => 2
            ],
            [
                'title' => 'Child Psychology in Sri Lanka',
                'author' => 'Dr. Hemamali Perera',
                'price' => 16.00,
                'stock' => 12,
                'book_category_id' => 2
            ],

            // Science & Technology
            [
                'title' => 'Wonder of Sri Lankan Wildlife',
                'author' => 'Ranjith Jayasinghe',
                'price' => 19.99,
                'stock' => 8,
                'book_category_id' => 3
            ],
            [
                'title' => 'Sri Lankan Innovations & Discoveries',
                'author' => 'Chandana Jayarathna',
                'price' => 17.50,
                'stock' => 10,
                'book_category_id' => 3
            ],

            // History
            [
                'title' => 'The Story of Sri Lanka',
                'author' => 'Prof. K.M. de Silva',
                'price' => 22.00,
                'stock' => 18,
                'book_category_id' => 4
            ],
            [
                'title' => 'Ancient Kingdoms of Ceylon',
                'author' => 'Gamini Wijesuriya',
                'price' => 18.50,
                'stock' => 12,
                'book_category_id' => 4
            ],

            // Biology
            [
                'title' => 'Biology for Sri Lankan Students',
                'author' => 'Dr. Nanda Gunawardena',
                'price' => 21.99,
                'stock' => 10,
                'book_category_id' => 5
            ],
            [
                'title' => 'Plants of Sri Lanka',
                'author' => 'Sarath Kotagama',
                'price' => 15.99,
                'stock' => 14,
                'book_category_id' => 5
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
