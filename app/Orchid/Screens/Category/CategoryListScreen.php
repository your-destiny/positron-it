<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryAddLayout;
use App\Orchid\Layouts\Category\CategoryEditLayout;
use App\Orchid\Layouts\Category\CategoryListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Категории';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Список категорий';

    /**
     * @var array|string[]
     */
    private array $screenData = [
        'model' => Category::class,
        'key' => 'categories',
        'routeRedirect' => 'platform.categories'
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
            ModalToggle::make('Добавить категорию')
                       ->icon('plus')
                       ->modal('addCategory')
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
            CategoryListLayout::class,
            Layout::modal(
                'addCategory',
                CategoryAddLayout::class
            )
                  ->title('Добавить категорию')
                  ->applyButton('Добавить'),

            Layout::modal(
                'editCategory',
                CategoryEditLayout::class
            )
                  ->title('Редактировать категорию')
                  ->applyButton('Редактировать')
                  ->async('asyncGetCategory'),
        ];
    }

    public function asyncGetCategory(Category $category): array
    {
        $books = $category->books()
                        ->get()
                        ->mapWithKeys(fn($el) => [$el->id => $el->id])
                        ->toArray();
        return [
            $this->screenData['key'] => $category,
            'books[]' => $books,
        ];
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $category = Category::create([
            'name' => $request->name
        ]);

        if (isset($request->books) && count($request->books) > 0) {
            $category->books()->sync($request->books);
        }

        if (!$request->parent) {
            Toast::warning("Операция обновления узлов не была выполнена, так как не выбран узел для действия");

            return redirect()->route($this->screenData['routeRedirect']);
        }

        $node = Category::find($request->parent);

        if (boolval($request->rootNode)) {
            $category->saveAsRoot();

            Toast::info("Операция добавления успешно завершена");

            return redirect()->route($this->screenData['routeRedirect']);
        }

        $func = $request->action_node;

        $this->$func($category, $node, $request->before_after);

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
        $updateData = $request->get($this->screenData['key']);

        $books = $request->get('books')
            ? $request->get('books')
            : [] ;

        ($this->screenData['model'])::find($updateData['id'])->books()->sync($books);

        if (boolval($request->name_or_all)) {
            $this->updateNode($updateData);

            Toast::info('Операция обновления успешно завершена, обновлены данные без узлов');

            return redirect()->route($this->screenData['routeRedirect']);
        }

        $this->updateNode($updateData);

        $category = Category::where('id', $updateData['id'])->first();

        if (boolval($request->rootNode)) {
            $category->saveAsRoot();

            Toast::info('Операция обновления успешно завершена,узел стал корневым');

            return redirect()->route($this->screenData['routeRedirect']);
        }

        if (!isset($updateData['parent_id'])) {
            Toast::warning('Операция обновления узлов не была выполнена, так как не выбран узел для дейсвтия');

            return redirect()->route($this->screenData['routeRedirect']);
        }

        $node = Category::find($updateData['parent_id']);

        if ($category->isDescendantOf($node) || $node->isDescendantOf($category)) {
            Toast::error('один из узлов не должен быть потомком.');

            return redirect()->route($this->screenData['routeRedirect']);
        }

/*        if ($category->parent_id == $node->id) {
            $this->inRootParent($category, $node, $request->before_after);

            Toast::info('Операция обновления успешно завершена');

            return redirect()->route($this->screenData['routeRedirect']);
        }*/

        $func = $request->action_node;

        $this->$func($category, $node, $request->before_after);

        Toast::info('Операция обновления успешно завершена');

        return redirect()->route($this->screenData['routeRedirect']);
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $category = Category::find($request->id);
        $category->delete();

        Toast::info('Операция удаления успешно завершена');

        return redirect()->route($this->screenData['routeRedirect']);
    }


    /**
     * @param  Category  $category
     * @param  Category  $node
     * @param  string  $place
     */
    private function inNode($category, $node, string $place): void
    {
        $place == 'before' ? $node->prependNode($category) : $node->appendNode($category);
    }

    /**
     * @param  Category  $category
     * @param  Category  $node
     * @param  string  $place
     */
    private function inRoot($category, $node, string $place): void
    {
        $place == 'before' ? $category->prependNode($node) : $category->appendNode($node);
    }

    /**
     * @param  Category  $category
     * @param  Category  $node
     * @param  string  $place
     */
    private function pasteInNode($category, $node, string $place): void
    {
        $place == 'before' ? $category->insertBeforeNode($node) : $category->insertAfterNode($node);
    }

    /**
     * @param  Category  $category
     * @param  Category  $node
     * @param  string  $place
     */
    private function inRootParent($category, $node, string $place): void
    {
        $node->ancestors->last()
            ? $this->inNode($category, $node->ancestors->last(), $place)
            : $category->saveAsRoot();
        $this->inNode($node, $category, $place);
    }

    private function updateNode($updateData): void
    {
        $model = new $this->screenData['model']();

        $model->where('id', $updateData['id'])
              ->update(['name' => $updateData['name']]);
    }
}
