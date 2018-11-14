<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following gateway to use.
    | You can switch to a different driver at runtime.
    |
    */
    'default' => 'smart_sms',
    /*
    |--------------------------------------------------------------------------
    | List of Drivers
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers to use for this package.
    | You can change the name. Then you'll have to change
    | it in the map array too.
    |
    */
    'drivers' => [
        'smart_sms' => [
            'url' => 'http://smartsmsgateway.com/api/api_json.php',
            'username' => 'awoklive',
            'password' => 'NR8LE3aW',
            'senderid' => 'AWOK',
            'type' => 'text',
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Class Maps
    |--------------------------------------------------------------------------
    |
    | This is the array of Classes that maps to Drivers above.
    | You can create your own driver if you like and add the
    | config in the drivers array and the class to use for
    | here with the same name. You will have to extend
    | Tzsk\Sms\Contract\MasterDriver in your driver.
    |
    */
    'map' => [
        'smart_sms' => \SmartSms\Driver\SmartSmsDriver::class,
    ]
];