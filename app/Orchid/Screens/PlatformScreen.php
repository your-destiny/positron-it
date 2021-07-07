<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Главная';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Главная страница';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [

            Link::make('Категории')
                ->route('platform.categories')
                ->icon('folder'),

            Link::make('Книги')
                ->route('platform.books')
                ->icon('book-open'),

            Link::make('Авторы')
                ->route('platform.authors')
                ->icon('user-follow'),

            Link::make('Обратная связь')
                ->route('platform.feedback')
                ->icon('folder'),

            Link::make('Настройки')
                ->route('platform.settings')
                ->icon('settings'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [

        ];
    }
}
