<?php

return [

    /*
     * Specifies the default driver used for document pdf generation.
     */

    'default' => env('DOCUMENT_DRIVER', 'browsershot'),

    /*
     * Defines each available document drivers. Use the disks you've
     * configured in config/filesystems.php.
     *
     * Supported: "browsershot",
     */

    'drivers' => [

        'browsershot' => [
            'driver' => 'browsershot',
            'disk' => 'public',
        ],
    ],
];
