<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Author;

use App\Models\Book;
use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class AuthorEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     * @throws BindingResolutionException
     */

    public function fields(): array
    {
        return [
            Input::make('authors.id')->hidden(),

            Input::make('authors.name')
                ->type('text')
                ->title('ФИО')
                ->style('color:black'),

            Relation::make('books[]')
                    ->fromModel(Book::class, 'title')
                    ->multiple()
                    ->title('Добавление книг')
                    ->popover('Авторы будут перезаписаны')
                    ->placeholder("Выберите книги"),
        ];
    }
}
