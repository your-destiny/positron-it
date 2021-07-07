<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Author;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AuthorListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'authors';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make("name", 'ФИО')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('Действие')->render(function ($author) {
                return DropDown::make()
                               ->icon('options-vertical')
                               ->list([
                                          ModalToggle::make(__('Edit'))
                                                     ->icon('pencil')
                                                     ->modal('editAuthor')
                                                     ->method('update')
                                                     ->modalTitle(
                                                         'Редактирование сотрудника ' . $author->name
                                                     )
                                                     ->asyncParameters(['file' => $author->id]),
                                          Button::make(__('Delete'))
                                                ->method('destroy')
                                                ->icon('trash')
                                                ->confirm('Вы действительно хотите
                                                 удалить этого автора?')
                                                ->parameters(['id' => $author->id])
                                      ]);
            })->align(TD::ALIGN_CENTER)->width('5%')->cantHide(false)
        ];
    }
}
