<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Author;

use App\Models\Author;
use App\Orchid\Layouts\Author\AuthorAddLayout;
use App\Orchid\Layouts\Author\AuthorEditLayout;
use App\Orchid\Layouts\Author\AuthorListLayout;
use App\Orchid\Traits\Crud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AuthorListScreen extends Screen
{
    use Crud;

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Авторы';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Авторы книг';

    /**
     * @var array|string[]
     */
    private array $screenData = [
        'model' => Author::class,
        'key' => 'authors',
        'routeRedirect' => 'platform.authors'
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            $this->screenData['key'] => ($this->screenData['model'])::filters()->paginate(10)
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
            ModalToggle::make('Добавить автора')
                       ->icon('plus')
                       ->modal('addAuthor')
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
            AuthorListLayout::class,
            Layout::modal(
                'addAuthor',
                AuthorAddLayout::class
            )
                  ->title('Добавить автора')
                  ->applyButton('Добавить'),
            Layout::modal(
                'editAuthor',
                AuthorEditLayout::class
            )
                  ->title('Редактировать автора')
                  ->applyButton('Редактировать')
                  ->async('asyncGetAuthor'),
        ];
    }

    public function asyncGetAuthor(Author $author): array
    {
        $books = $author->books()
                        ->get()
                        ->mapWithKeys(fn($el) => [$el->id => $el->id])
                        ->toArray();

        return [
            $this->screenData['key'] => $author,
            'books[]' => $books
        ];
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $model = new $this->screenData['model']();

        $book = $request->all();

        $model->fill($book)->save();

        if (isset($book['books']) && count($book['books']) > 0) {
            $model->books()->sync($book['books']);
        }

        Toast::info("Операция добавления успешно завершена");

        return redirect()->route($this->screenData['routeRedirect']);
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $author = $request->all()['authors'];

        $model = ($this->screenData['model'])::find($author['id']);

        $books = $request->get('books')
            ? $request->get('books')
            : [] ;

        $model->update($author);

        $model->books()->sync($books);

        Toast::info('Операция обновления успешно завершена');

        return redirect()->route($this->screenData['routeRedirect']);
    }
}
