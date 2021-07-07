<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;


use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CategoryEditLayout extends Rows
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
            Input::make('categories.id')->hidden(),

            Input::make('categories.name')
                 ->type('text')
                 ->max(255)
                 ->title('Название')
                 ->required()
                 ->placeholder("Введите название категории"),

            CheckBox::make('name_or_all')
                    ->value(0)
                    ->placeholder('Изменить поля кроме узлов')
                    ->help('Выберите, если не хотити менять узлы')
                    ->sendTrueOrFalse(),


            Relation::make('categories.parent_id')
                    ->fromModel(Category::class, 'name')
                    ->title('Выберите узел')
                    ->placeholder("Выберите узел для действия"),

            CheckBox::make('rootNode')
                    ->value(0)
                    ->placeholder('Сделать корневым')
                    ->help('Выберите, если хотите сделать категорию корневой, действие в этом случае не влияет')
                    ->sendTrueOrFalse(),

            Select::make('action_node')
                  ->options([
                                'inNode'   => 'добавить как потомок выбранного узла',
                                'inRoot' => 'добавить как родитель выбранного узла',
                                'pasteInNode' => 'вставить рядом с выбранным узлом',
                            ])
                  ->required()
                  ->title('Выберите действие'),

            Select::make('before_after')
                  ->options([
                                'before' => 'до узла',
                                'after'  => 'после узла',
                            ])
                  ->required()
                  ->title('Выберите место добавления(вставки)'),

            Relation::make('books[]')
                    ->fromModel(Book::class, 'title')
                    ->multiple()
                    ->title('Добавление книг')
                    ->popover('Книги будут перезаписаны')
                    ->placeholder("Выберите книги"),
        ];
    }
}
