<?php

namespace App\Containers\Books\Tasks;

use App\Abstracts\Task;
use App\Containers\Books\Classes\BinderImagesBooks;
use Async;
use Illuminate\Support\Collection;

class CreateBooksImagesTask extends Task
{
    public function __construct(
    private Collection $books
    ) {
    }

    public function run()
    {
        $this->books
            ->map(fn($el) => $el->get('image'))
            ->filter(fn($el) => $el)
            ->values()
            ->each(function ($el) {
                Async::run(function () use ($el) {
                    (new BinderImagesBooks())->saveImage($el);
                });
            });
        Async::wait();
    }
}
