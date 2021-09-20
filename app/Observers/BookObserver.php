<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class BookObserver
{
    public function created(Book $book)
    {
        Cache::forget('books');
    }

    public function updated(Book $book)
    {
        Cache::forget('books');
    }

    public function deleted(Book $book)
    {
        Cache::forget('books');
    }
}
