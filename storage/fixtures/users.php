<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.08.18
 * Time: 16:49
 */

return [
    [
        'id' => 1,
        'name' => 'username1',
        'email' => 'admin1@example.com',
        'password' => Hash::make('1234'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'id' => 2,
        'name' => 'username2',
        'email' => 'admin2@example.com',
        'password' => Hash::make('1234'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
];