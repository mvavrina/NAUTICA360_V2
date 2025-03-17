<?php

return[
    'base_url' => match (env('APP_ENV')) {
        'beta' => 'http://beta.booking-manager.com/api/v2',
        'swagger' => 'https://virtserver.swaggerhub.com/mmksystems/bm-api/2.0.0',
        default => 'https://www.booking-manager.com/api/v2',
    },
];