<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;

use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SettingListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'settings';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make("name", 'Название')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make("value", 'Значение')
              ->sort()
              ->filter(TD::FILTER_TEXT),

            TD::make('Действие')->render(function ($setting) {
                return DropDown::make()
                               ->icon('options-vertical')
                               ->list([
                                          ModalToggle::make(__('Edit'))
                                                     ->icon('pencil')
                                                     ->modal('editSetting')
                                                     ->method('update')
                                                     ->modalTitle(
                                                         'Редактирование сотрудника ' . $setting->name
                                                     )
                                                     ->asyncParameters(['file' => $setting->id]),
                                      ]);
            })->align(TD::ALIGN_CENTER)->width('5%')->cantHide(false)
        ];
    }
}
