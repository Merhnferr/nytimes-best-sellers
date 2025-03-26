<?php

declare(strict_types=1);

namespace Tests\DataFixtures;

class NYTimesResponseFixture
{
    public static function okResponse(): array
    {
        return [
            'status' => 'OK',
            'num_results' => 1,
            'results' => [
                [
                    'title' => 'Lorem Ipsum',
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
