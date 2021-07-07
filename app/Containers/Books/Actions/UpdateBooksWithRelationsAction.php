<?php

namespace App\Containers\Books\Actions;

use App\Abstracts\Action;
use App\Containers\Books\Tasks\CreateBooksImagesTask;
use App\Containers\Books\Tasks\UpdateBooksWithCategoriesAndAuthorsTask;
use Illuminate\Support\Collection;
use Async;

class UpdateBooksWithRelationsAction extends Action
{

    public function __construct(
    private Collection $books
    ) {
    }

    public function run(): bool
    {
        if ($this->books->count() > 0) {
            (new UpdateBooksWithCategoriesAndAuthorsTask($this->books))->run();
            (new CreateBooksImagesTask($this->books))->run();
        }

        return true;
    }
}
