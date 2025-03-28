<?php

declare(strict_types=1);

namespace Tests\DataFixtures;

class NYTimesResponseFixture
{
    public static function okResponse(): array
    {
        return [
            'status' => 'OK',
            'copyright' => 'Copyright (c) 2019 The New York Times Company.  All Rights Reserved.',
            'num_results' => 1,
            'results' => [
                [
                    'title' => '#GIRLBOSS',
                    'description' => 'An online fashion retailer traces her path to success.',
                    'contributor' => 'by Sophia Amoruso',
                    'author' => 'Sophia Amoruso',
                    'contributor_note' => '',
                    'price' => 0,
                    'age_group' => '',
                    'publisher' => 'Portfolio/Penguin/Putnam',
                    'isbns' => [
                        [
                            'isbn10' => '039916927X',
                            'isbn13' => '9780399169274',
                        ],
                    ],
                    'ranks_history' => [
                        [
                            'primary_isbn10' => '1591847931',
                            'primary_isbn13' => '9781591847939',
                            'rank' => 8,
                            'list_name' => 'Business Books',
                            'display_name' => 'Business',
                            'published_date' => '2016-03-13',
                            'bestsellers_date' => '2016-02-27',
                            'weeks_on_list' => 0,
                            'ranks_last_week' => null,
                            'asterisk' => 0,
                            'dagger' => 0,
                        ],
                    ],
                    'reviews' => [
                        [
                            'book_review_link' => '',
                            'first_chapter_link' => '',
                            'sunday_review_link' => '',
                            'article_chapter_link' => '',
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function unauthorizedResponse(): array
    {
        return [
            'fault' => [
                'faultString' => 'Invalid ApiKey',
                'detail' => [
                    'errorcode' => 'oauth.v2.InvalidApiKey',
                ],
            ],
        ];
    }
}
