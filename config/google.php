<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Sheets Service
    |--------------------------------------------------------------------------
    */
    'service' => [
        /*
        | Enable service account authentication
        */
        'enable' => true,

        /*
        | Path to the json file
        */
        'file' => storage_path('app/credentials.json'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Spreadsheet ID
    |--------------------------------------------------------------------------
    |
    | Reference in config, but we are overriding this with DB settings in the Service.
    */ 
    'post_spreadsheet_id' => '',
    
    'access_type' => 'offline',

    'scopes' => [\Google\Service\Sheets::DRIVE, \Google\Service\Sheets::SPREADSHEETS],
];
