<?php

return [

    /*
     * Specifies the default driver used for document pdf generation.
     *
     * Supported: "snappy", "browsershot"
     */

    'default_driver' => env('DOCUMENT_DRIVER', 'snappy'),
];
