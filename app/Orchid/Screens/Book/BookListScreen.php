<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Book;

use App\Models\Book;
use App\Orchid\Layouts\Book\BookAddLayout;
use App\Orchid\Layouts\Book\BookEditLayout;
use App\Orchid\Layouts\Book\BookListLayout;
use App\Orchid\Layouts\Book\BookLongDescriptionLayout;
use App\Orchid\Layouts\Book\BookShortDescriptionLayout;
use App\Orchid\Traits\Crud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BookListScreen extends Screen
{
    use Crud;

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Книги';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Книги';

    /**
     * @var array|string[]
     */
    private array $screenData = [
        'model' => Book::class,
        'key' => 'books',
        'routeRedirect' => 'platform.books'
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
            ModalToggle::make('Добавить книгу')
                       ->icon('plus')
                       ->modal('addBook')
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
            BookListLayout::class,
            Layout::modal(
                'addBook',
                BookAddLayout::class
            )
                  ->title('Добавить книгу')
                  ->applyButton('Добавить'),
            Layout::modal(
                'editBook',
                BookEditLayout::class
            )
                  ->title('Редактировать книгу')
                  ->applyButton('Редактировать')
                  ->async('asyncGetBook'),

            Layout::modal(
                'getLongDescription',
                BookLongDescriptionLayout::class
            )
                  ->title('Показать полное содержание')
                  ->withoutApplyButton()
                  ->async('asyncGetBook'),

            Layout::modal(
                'getShortDescription',
                BookShortDescriptionLayout::class
            )
                  ->title('Показать краткое содержание')
                  ->withoutApplyButton()
                  ->async('asyncGetBook'),
        ];
    }

    public function asyncGetBook(Book $book): array
    {
        $categories = $book->categories()
                                ->get()
                                ->mapWithKeys(fn($el) => [$el->id => $el->id])
                                ->toArray();

        $authors = $book->authors()
                           ->get()
                           ->mapWithKeys(fn($el) => [$el->id => $el->id])
                           ->toArray();
        return [
            $this->screenData['key'] => $book,
            'categories[]' => $categories,
            'authors[]' => $authors
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

        if ($request->file('thumbnailUrl')) {
            $imageContent = $request->file('thumbnailUrl')->getContent();
            $imageName = $request->file('thumbnailUrl')->hashName();

            if (!Storage::disk('books')->exists($imageName)) {
                Storage::disk('books')->put($imageName, $imageContent);
            }

            $book['thumbnailUrl'] = $imageName;
        }

        $model->fill($book)->save();

        if (isset($book['categories']) && count($book['categories']) > 0) {
            $model->categories()->sync($book['categories']);
        }

        if (isset($book['authors']) && count($book['authors']) > 0) {
            $model->authors()->sync($book['authors']);
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
        $book = $request->all()['books'];

        $model = ($this->screenData['model'])::find($book['id']);

        $categories = $request->get('categories')
            ? $request->get('categories')
            : [];
        $authors = $request->get('authors')
            ? $request->get('authors')
            : [];

        if ($request->file('books.thumbnailUrl')) {
            $imageContent = $request->file('books.thumbnailUrl')->getContent();
            $imageName = $request->file('books.thumbnailUrl')->hashName();

            if (!Storage::disk('books')->exists($imageName)) {
                Storage::disk('books')->put($imageName, $imageContent);
            }

            $book['thumbnailUrl'] = $imageName;
        }

        $model->update($book);

        $model->categories()->sync($categories);

        $model->authors()->sync($authors);

        Toast::info('Операция обновления успешно завершена');

        return redirect()->route($this->screenData['routeRedirect']);
    }
}
