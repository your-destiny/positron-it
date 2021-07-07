<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;

use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SettingEditLayout extends Rows
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
            Input::make('settings.id')->hidden(),

            Input::make('settings.name')
                ->type('text')
                ->title('Название')
                ->style('color:black')
                ->disabled(),

            Input::make('settings.value')
                 ->type('text')
                 ->required()
                 ->title('Значение')
                 ->placeholder("Введите значение настройки"),

        ];
    }
}
