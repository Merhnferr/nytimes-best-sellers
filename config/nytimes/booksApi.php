<?php

return [
    'apiKey' => (string) env('NYT_API_KEY'),
    'baseUrl' => 'https://api.nytimes.com/svc/books/v3',
    'endpoints' => [
        'lists' => [
            'bestSellersHistory' => '/lists/best-sellers/history.json',
        ],
    ],
];
