<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [            'name' => 'url для книг',
                         'code' => 'book_parsing_url',
                         'value' => 'https://gitlab.com/prog-positron/test-app-vacancy/-/raw/master/books.json'
            ],
            [            'name' => 'email получателя писем с обратной связи',
                         'code' => 'email_recipient',
                         'value' => 'admin@admin.com'
            ],
            [            'name' => 'Количество книг на странице',
                         'code' => 'paginate_books',
                         'value' => '5'
            ]
        ]);
    }
}
