<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;


use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SettingAddLayout extends Rows
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
                 ->title('Название'),

            Input::make('code')
                 ->type('text')
                 ->title('Код настройки')
                 ->placeholder("Введите код настройки"),

            Input::make('value')
                 ->type('text')
                 ->required()
                 ->title('Значение')
                 ->placeholder("Введите значение настройки"),
        ];
    }
}
