<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default
    |--------------------------------------------------------------------------
    |
    | The default channel name to use if none is specified.
    |
    */

    'default' => 'transactional',

    /*
    |--------------------------------------------------------------------------
    | Channels
    |--------------------------------------------------------------------------
    |
    | A channel is a route for sending outbound communication to a user.
    |
    | As an example, you may have one SMS channel used for transactional
    | messages and a secondary channel for bulk communication.
    |
    */

    'channels' => [

        'transactional' => [
            'driver' => 'totalsend',
            'username' => null,
            'password' => null,
            'from' => null,
        ],

        'marketing' => [
            'driver' => 'totalsend',
            'username' => null,
            'password' => null,
            'from' => null,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Queue
    |--------------------------------------------------------------------------
    |
    | The queue on which messages will be sent.
    |
    */

    'queue' => env('SMS_QUEUE', 'sms'),

];
