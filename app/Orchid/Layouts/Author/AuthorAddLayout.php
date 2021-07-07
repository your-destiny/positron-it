<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Author;


use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class AuthorAddLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */

    public function fields(): array
    {
        return [
            Input::make('name')
                ->required()
                 ->type('text')
                 ->title('ФИО'),

            Relation::make('books[]')
                    ->fromModel(Book::class, 'title')
                    ->multiple()
                    ->title('Добавление книг')
                    ->placeholder("Выберите книги"),
        ];
    }
}
