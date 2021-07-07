<?php

return [
    'default_book_parsing_url' => env(
        'DEFAULT_BOOK_PARSING_URL',
        'https://gitlab.com/prog-positron/test-app-vacancy/-/raw/master/books.json'
    ),

    'default_email_recipient' => env(
        'DEFAULT_EMAIL_RECIPIENT',
        'test@test.ru'
    ),

    'default_paginate_books' => env(
        'DEFAULT_PAGINATE_BOOKS',
        6
    ),

];
