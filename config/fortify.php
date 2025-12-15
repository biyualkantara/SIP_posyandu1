<?php

return [

    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email',

    'email' => 'email',

    'views' => true,

    'features' => [
        Laravel\Fortify\Features::registration(),
        Laravel\Fortify\Features::resetPasswords(),
    ],
];