<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;


use App\Models\Book;
use App\Models\Category;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CategoryAddLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */

    public function fields(): array
    {
        return [
            Input::make('name')
                 ->type('text')
                 ->max(255)
                 ->title('Название')
                 ->required()
                 ->placeholder("Введите название категории"),

            Relation::make('parent')
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
                                'inRootParent' => 'добавить как родитель выбранного узла',
                                'pasteInNode' => 'вставить рядом с выбранным узлом',
                            ])
                  ->required()
                  ->title('Выберите действие')
                  ->popover('Если сделать категорию родителем выбранного узла, то она станет корневой'),

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
                    ->placeholder("Выберите книги"),
        ];
    }
}
