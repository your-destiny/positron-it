<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Feedback;

use App\Models\Feedback;
use App\Models\Setting;
use App\Orchid\Layouts\Feedback\FeedbackListLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class FeedbackListScreen extends Screen
{

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Обратная связь';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Заявки с формы обратной связи';

    /**
     * @var array|string[]
     */
    private array $screenData = [
        'model' => Feedback::class,
        'key' => 'feedback',
        'routeRedirect' => 'platform.feedback'
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
        return [];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            FeedbackListLayout::class
        ];
    }
}
