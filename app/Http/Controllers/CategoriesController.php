<?php

namespace App\Http\Controllers;

use App\Containers\Books\Classes\BinderImagesBooks;
use App\Models\Category;
use App\Models\Setting;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories', [
            'categories' => Category::withDepth()
                                    ->defaultOrder()
                                    ->get()
                                    ->toTree(),
        ]);
    }

    public function show($category)
    {
        $category = Category::with('books')
                            ->descendantsAndSelf($category)
                            ->toTree()
                            ->first();


        if (isset($category->books)) {
            $category->books = collect($category->books)->map(
                function ($el) {
                    $temp = $el;
                    $temp['thumbnailUrl'] = (new BinderImagesBooks())->getBookImage($el);
                    return $temp;
                }
            );
        }

        $paginate = Setting::where('code', 'paginate_books')->first();

        $paginate = $paginate ? $paginate->value : config('settings.default_paginate_books');

        return Inertia::render('Categories', [
            'categories' => $category,
            'paginate' => $paginate
        ]);
    }
}
