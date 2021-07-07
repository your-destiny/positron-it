<?php

namespace App\Containers\Books\Tasks;

use App\Abstracts\Task;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Collection;

class UpdateBooksWithCategoriesAndAuthorsTask extends Task
{
    public function __construct(
    private Collection $books
    ) {
    }

    public function run()
    {
        $this->books->each(function ($el) {
            $book = Book::create($el->get('book')->toArray());

            $el->get('categories')->each(function ($category) use ($book) {
                $category = Category::firstOrCreate(['name' => $category]);
                $category->books()->attach($book->id);
            });

            $el->get('authors')->each(function ($author) use ($book) {
                $author = Author::firstOrCreate(['name' => $author]);
                $author->books()->attach($book->id);
            });
        });
    }
}
