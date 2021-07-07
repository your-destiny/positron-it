<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use App\Models\FacultyStaff;
use App\Models\FileStorageInfo;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'categories';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make("name", 'Название')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->width('35%'),

            TD::make("parent", 'Родитель')
              ->width('35%')
              ->render(fn(Category $category) => Category::where('id', $category->parent_id)->first()->name ?? 'Нет родителя')
            ,

            TD::make('Действие')->render(function ($category) {
                return DropDown::make()
                               ->icon('options-vertical')
                               ->list([
                                          ModalToggle::make(__('Edit'))
                                                     ->icon('pencil')
                                                     ->modal('editCategory')
                                                     ->method('update')
                                                     ->modalTitle(
                                                         'Редактировать категорию ' . $category->Name
                                                     )
                                                     ->asyncParameters(['category' => $category->id]),
                                          Button::make(__('Delete'))
                                                ->method('destroy')
                                                ->icon('trash')
                                                ->confirm('Вы действительно хотите
                                                 удалить эту категорию? Также удалятся все потомки')
                                            ->parameters(['id' => $category->id])

                                      ]);
            })->align(TD::ALIGN_CENTER)->width('5%')->cantHide(false)
        ];
    }

}
