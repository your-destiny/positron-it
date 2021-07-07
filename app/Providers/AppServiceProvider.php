<?php

namespace App\Providers;

use App\Abstracts\Action;
use App\Containers\Books\Actions\UpdateBooksWithRelationsAction;
use App\Containers\Books\Classes\BookParser;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }
                return $value;
            });
        });


        $this->app->bind(UpdateBooksWithRelationsAction::class, function () {
            $bookParsingUrl = Setting::where('code', 'book_parsing_url')->first();
            $bookParsingUrl = $bookParsingUrl ? $bookParsingUrl->value : config('settings.default_book_parsing_url');

            return (new UpdateBooksWithRelationsAction(
                (new BookParser($bookParsingUrl))
                    ->readJsonFromUri()
            ))->run();
        });
    }
}
