<?php

return [
    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('cache/views'))),
    'paths'    => [base_path('templates')],
];
