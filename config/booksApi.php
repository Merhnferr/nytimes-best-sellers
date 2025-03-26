<?php

return [
    'apiKey' => (string) env('NYT_API_KEY'),
    'baseUrl' => 'https://api.nytimes.com/svc/books/',
    'version' => 'v3',
    'endpoints' => [
        'v3' => [
            'lists' => [
                'bestSellersHistory' => '/lists/best-sellers/history.json',
            ],
        ],
    ],
];
