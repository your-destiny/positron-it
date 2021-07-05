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
        $this->binderImagesBook = new BinderImagesBooks();
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

        $file = $file
            ->collect()
            ->recursive()
            ->whereIn('isbn', $isbnUnique->toArray())->toArray();

        $pool = Pool::create();

        foreach (range(0, 393) as $i) {
            $el = $file[$i];
            $pool[] = async(function () use ($el) {
                $temp = $el;

                $temp['publishedDate'] = $this->bookDateConvert($temp['publishedDate']);

                $temp['thumbnailUrl'] = $this->binderImagesBook->getImage($temp['thumbnailUrl'] ?? '');

                return[
                                    'book' => $temp,
                                    'categories' => $temp['categories'] ?? [],
                                    'authors' => $temp['authors'] ?? []
                                ];
            })->then(function ($output) use ($newBooks) {
                $newBooks->push($output);
            });
        }
        await($pool);
            /*->each(function ($el) use ($newBooks) {


                    $temp = $el;

                    $temp['publishedDate'] = $this->bookDateConvert($temp['publishedDate']);

                    $temp['thumbnailUrl'] = $this->binderImagesBook->getImage($temp['thumbnailUrl']);

                    $newBooks->push([
                                        'book' => $temp,
                                        'categories' => $temp['categories'],
                                        'authors' => $temp['authors']
                    ]);
                return true;
            });*/
        $s = $newBooks->toArray();
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

    private function bookDateConvert($date): ?string
    {
        $date = $date['$date'] ?? null;

        if ($date) {
            return Carbon::make($date)->format((new Book())->getDateFormat());
        }

        return $date;
    }
}
