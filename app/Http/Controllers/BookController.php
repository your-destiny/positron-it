<?php

namespace App\Http\Controllers;

use App\Containers\Books\Classes\BinderImagesBooks;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    public function show($book)
    {
        $book = Book::where('id', $book)
                        ->with('categories')
                        ->with('authors')
                        ->first();

        $book->thumbnailUrl = $book->thumbnailUrl
            ? (new BinderImagesBooks())->getBookImage($book)
            : '';

        return Inertia::render('BookDetail', [
            'book' => $book,
        ]);
    }
}
