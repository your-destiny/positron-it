<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Book;


use Orchid\Screen\Field;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class BookLongDescriptionLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */

    public function fields(): array
    {

        return [
            TextArea::make('books.longDescription')
             ->disabled()
             ->style('color:black')
             ->rows(15)

        ];
    }
}
