<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Book;


use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class BookAddLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */

    public function fields(): array
    {

        return [
            Input::make('title')
                ->required()
                 ->type('text')
                 ->title('Название')
                ->placeholder("Введите название"),

            Input::make('isbn')
                 ->required()
                 ->type('text')
                 ->title('isbn')
                 ->placeholder("Введите isbn"),

            Relation::make('categories[]')
                    ->fromModel(Category::class, 'name')
                    ->multiple()
                    ->title('Добавление категорий')
                    ->placeholder("Выберите категории"),

            Relation::make('authors[]')
                    ->fromModel(Author::class, 'name')
                    ->multiple()
                    ->title('Выберите авторов')
                    ->placeholder("Выберите авторов"),

            Input::make('pageCount')
                 ->type('number')
                 ->title('Количество страниц')
                 ->placeholder("Введите количество страниц"),

            DateTimer::make('publishedDate')
                     ->title('Дата публикации')
                    ->placeholder("Выберите дату публикации")
                     ->enableTime(),

            Input::make('thumbnailUrl')
                 ->type('file')
                 ->title('Изображения')
                 ->placeholder("Загрузите изображение"),


            Quill::make('shortDescription')
                ->title('Краткое содержание')
                ->placeholder("Введите краткое содержание"),

            Quill::make('longDescription')
                 ->title('Подробнее содержание')
                 ->placeholder("Введите подробнее содержание"),

            Input::make('status')
                 ->type('text')
                 ->title('Статус')
                 ->placeholder("Введите статус"),
        ];
    }
}
