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
        return [
            $this->screenData['key'] => $category
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

        $node = Category::find($request->parent);

        $func = $request->action_node;

        $this->$func($category, $node, $request->before_after);

        //$category->prependNode($node); // сделать родителем с добавлением до узла (станет корнем)
        //$category->appendNode($node); // сделать родителем с добавлением после узла (станет корнем)

        //$node->prependNode($category); // сделать потомком с добавлением до узла
        //$node->appendNode($category); // сделать потомком с добавлением после узла

        //$category->insertBeforeNode($node); // вставить до узла
        //$category->insertAfterNode($node); // вставить после узла


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

        if (boolval($request->name_or_all)) {
            $model = new $this->screenData['model']();

            $model->where('id', $updateData['id'])
                  ->update(['name' => $updateData['name']]);

            return redirect()->route($this->screenData['routeRedirect']);
        }

        $category = Category::where('id', $updateData['id'])->first();

        $node = Category::find($updateData['parent_id']);

        $func = $request->action_node;

        $this->$func($category, $node, $request->before_after);

        Toast::info('Операция обновления успешно завершена');

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
}
