<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Feedback;

use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FeedbackListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'feedback';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make("name", 'ФИО')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make("email", 'email')
              ->sort()
              ->filter(TD::FILTER_TEXT),

            TD::make("email", 'tel')
              ->sort()
              ->filter(TD::FILTER_TEXT),

            TD::make("message", 'Содержание')
              ->sort()
              ->filter(TD::FILTER_TEXT),

            TD::make("created_at", 'Дата создания')
              ->sort()
              ->filter(TD::FILTER_TEXT)
            ->render(fn($el) => date_format($el->created_at, 'd.m.y')),

        ];
    }
}
