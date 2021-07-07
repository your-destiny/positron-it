<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Setting;

use App\Models\Setting;
use App\Orchid\Layouts\Setting\SettingAddLayout;
use App\Orchid\Layouts\Setting\SettingEditLayout;
use App\Orchid\Layouts\Setting\SettingListLayout;
use App\Orchid\Traits\Crud;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class SettingListScreen extends Screen
{
    use Crud;

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Настройки';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Настройки приложения';

    /**
     * @var array|string[]
     */
    private array $screenData = [
        'model' => Setting::class,
        'key' => 'settings',
        'routeRedirect' => 'platform.settings'
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            $this->screenData['key'] => ($this->screenData['model'])::filters()->paginate(5)
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('Добавить настройку')
                       ->icon('plus')
                       ->modal('addSetting')
                       ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            SettingListLayout::class,
            Layout::modal(
                'addSetting',
                SettingAddLayout::class
            )
                  ->title('Добавить настройку')
                  ->applyButton('Добавить'),
            Layout::modal(
                'editSetting',
                SettingEditLayout::class
            )
                  ->title('Редактировать настройку')
                  ->applyButton('Редактировать')
                  ->async('asyncGetSetting'),
        ];
    }

    public function asyncGetSetting(Setting $setting): array
    {
        return [
            $this->screenData['key'] => $setting
        ];
    }
}
