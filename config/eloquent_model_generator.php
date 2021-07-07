<?php

use Illuminate\Database\Eloquent\Model;

return [
    'model_defaults' => [
        'namespace'       => 'App\Models',
        'base_class_name' => Model::class,
        'output_path' =>    "Models",
        'no_timestamps'   => false,
        'date_format'     => 'd.m.y',
        'connection'      => null,
        'backup'          => null,
    ],
];
