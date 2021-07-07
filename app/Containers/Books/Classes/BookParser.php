<?php

namespace App\Containers\Books\Classes;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\Pure;
use Spatie\Async\Pool;
use Throwable;

class BookParser
{
    /**
     * @var BinderImagesBooks
     */
    private BinderImagesBooks $binderImagesBook;

    /**
     * BookParser constructor.
     *
     * @param  string  $uri
     */
    #[Pure] public function __construct(
    private string $uri,
    ) {
    }

    public function readJsonFromUri(): Collection
    {
        $file = Http::get($this->uri);
        $file->throw();

        $isbnUnique = $file
            ->collect()
            ->map(fn($el) => $el['isbn'] ?? '')
            ->diff(Book::pluck('isbn')->toArray())
            ->values();

        $newBooks = collect();

        $file
            ->collect()
            ->recursive()
            ->whereIn('isbn', $isbnUnique->toArray())
            ->each(function ($el) use ($newBooks) {
                    $temp = $el;

                    $temp->put('publishedDate', $this->bookDateConvert($temp->get('publishedDate')));

                    $imageUrl = $temp['thumbnailUrl'] ?? null;

                    $temp['thumbnailUrl'] = (new BinderImagesBooks())
                        ->getNameForDatabase($temp['thumbnailUrl'] ?? null);

                    $newBooks->push(collect([
                        'book' => $temp,
                        'categories' => $this->checkCategoriesIsEmpty($this->filterCollection($temp['categories'])),
                        'authors' => $this->filterCollection($temp['authors']),
                        'image' => $imageUrl
                    ]));

                return true;
            });

        return $newBooks;
    }

    private function addMissingAttributesToBookModelArray(array $elements): array
    {
        $fillAbleBookAttributes = collect((new Book())->getFillable())
            ->filter(fn($el) => $el != 'created_at' && $el != 'updated_at')
            ->toArray();

        foreach ($elements as &$element) {
            foreach ($fillAbleBookAttributes as $item) {
                if (!in_array($item, array_keys($element))) {
                    $element[$item] = null;
                }
            }
        }

        return $elements;
    }

    private function bookDateConvert(?Collection $date): ?string
    {
        if (!$date) {
            return $date;
        }

        $date = $date->get('$date');

        return Carbon::make($date)->format((new Book())->getDateFormat());
    }

    private function filterCollection(Collection $data): Collection
    {
        return $data->filter(fn($el) => $el)->values();
    }

    private function checkCategoriesIsEmpty(Collection $categories): Collection
    {
        return $categories->count() == 0
            ? collect(['Новинки'])
            : $categories;
    }
}
