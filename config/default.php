<?php

return [

    'root_user' => [
        'name' => env('ROOT_USERNAME'),
        'email' => env('ROOT_EMAIL'),
        'password' => env('ROOT_PASSWORD')
    ],

    'starting_cash' => env('STARTING_CASH'),
    'starting_bank' => env('STARTING_BANK'),

];
