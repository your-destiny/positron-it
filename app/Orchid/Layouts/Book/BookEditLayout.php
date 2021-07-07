<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Book;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class BookEditLayout extends Rows
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
            Input::make('books.id')->hidden(),

            Input::make('books.title')
                 ->required()
                 ->type('text')
                 ->title('Название')
                 ->placeholder("Введите название"),

            Input::make('books.isbn')
                 ->required()
                 ->type('text')
                 ->title('isbn')
                 ->placeholder("Введите isbn"),

            Group::make([
                            Relation::make('categories[]')
                                    ->fromModel(Category::class, 'name')
                                    ->multiple()
                                    ->title('Выберите категории')
                                    ->placeholder("Выберите категории")
                            ->popover('Категории будут перезаписаны'),

                            Relation::make('authors[]')
                                    ->fromModel(Author::class, 'name')
                                    ->multiple()
                                    ->title('Выберите авторов')
                                    ->placeholder("Выберите авторов")
                                    ->popover('Авторы будут перезаписаны'),
                        ]),

            Input::make('books.pageCount')
                 ->type('number')
                 ->title('Количество страниц')
                 ->placeholder("Введите количество страниц"),

            DateTimer::make('books.publishedDate')->format((new Book())->getDateFormat())
                     ->title('Дата публикации')
                     ->placeholder("Выберите дату публикации")
                     ->enableTime(),

            Input::make('books.thumbnailUrl')
                 ->type('file')
                 ->title('Изображения')
                 ->placeholder("Загрузите изображение"),

            Quill::make('books.shortDescription')
                 ->title('Краткое содержание')
                 ->placeholder("Введите краткое содержание"),

            Quill::make('books.longDescription')
                 ->title('Подробнее содержание')
                 ->placeholder("Введите подробнее содержание"),

            Input::make('books.status')
                 ->type('text')
                 ->title('Статус')
                 ->placeholder("Введите статус"),

        ];
    }
}
