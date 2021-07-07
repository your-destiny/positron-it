<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Book;


use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class BookShortDescriptionLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */

    public function fields(): array
    {

        return [
            TextArea::make('books.shortDescription')
              ->disabled()
             ->style('color:black')
             ->rows(15)
        ];
    }
}
