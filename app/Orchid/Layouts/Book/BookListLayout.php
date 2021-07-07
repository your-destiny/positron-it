<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Book;

use App\Containers\Books\Classes\BinderImagesBooks;
use App\Models\Book;
use App\Models\FacultyStaff;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BookListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'books';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('title', 'Название')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('isbn', 'isbn')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('pageCount', 'Количество страниц')
                ->sort()
                ->filter(TD::FILTER_TEXT)->width('5%')->align(TD::ALIGN_CENTER),

            TD::make('publishedDate', 'Дата публикации')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(fn($el) => $el->publishedDate
                    ? Carbon::make($el->publishedDate)->format('d.m.Y')
                    : ''
                ),

            TD::make('thumbnailUrl', 'Изображение')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->align(TD::ALIGN_CENTER)
                ->render(fn(Book $book) => $this->getBookImage($book)),

            TD::make('shortDescription', 'Краткое содержание')
              ->sort()
              ->filter(TD::FILTER_TEXT)
              ->render(fn($el) => ModalToggle::make('Показать')
                                             ->modal('getShortDescription')
                                             ->modalTitle(
                                                 'Краткое содержание' . $el->name
                                             )
                                             ->asyncParameters(['book' => $el->id]),),

            TD::make('longDescription', 'Подробнее содержание')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(fn($el) => ModalToggle::make('Показать')
                                               ->modal('getLongDescription')
                                               ->modalTitle(
                                                   'Полное содержание' . $el->name
                                               )
                                               ->asyncParameters(['book' => $el->id]),),

            TD::make('status', 'Статус')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('Действие')->render(function ($book) {
                return DropDown::make()
                               ->icon('options-vertical')
                               ->list([
                                          ModalToggle::make(__('Edit'))
                                                     ->icon('pencil')
                                                     ->modal('editBook')
                                                     ->method('update')
                                                     ->modalTitle(
                                                         'Редактирование сотрудника ' . $book->name
                                                     )
                                                     ->asyncParameters(['book' => $book->id]),

                                          Button::make(__('Delete'))
                                                ->method('destroy')
                                                ->icon('trash')
                                                ->confirm('Вы действительно хотите
                                                 удалить эту книгу?')
                                                ->parameters(['id' => $book->id])
                                      ]);
            })->align(TD::ALIGN_CENTER)->width('5%')->cantHide(false)
        ];
    }

    public function getBookImage(Book $book)
    {
        $filename = $book->thumbnailUrl ?? '';

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        try {
            $file = Storage::disk('books')->get($filename);
        } catch (FileNotFoundException $e) {
            $file = '';
        }

        return view(
            'image',
            ['image' => sprintf(
                "data:image/{$extension};base64, %s",
                base64_encode($file ?? '')
            )]
        );
    }
}
