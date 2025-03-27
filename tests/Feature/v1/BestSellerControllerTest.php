<?php

declare(strict_types=1);

namespace Tests\Feature\v1;

use App\Helpers\CacheHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\DataFixtures\NYTimesResponseFixture;
use Tests\TestCase;

class BestSellerControllerTest extends TestCase
{
    private const ROUTE = '/api/v1/best-sellers/history';

    private const URL_TO_FAKE = 'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json*';

    protected function tearDown(): void
    {
        Cache::flush();

        parent::tearDown();
    }

    public function test_list_history_successful(): void
    {
        Http::fake([
            self::URL_TO_FAKE => Http::response(NYTimesResponseFixture::okResponse()),
        ]);

        $response = $this->get(self::ROUTE);

        $this->assertTrue(Cache::has(CacheHelper::buildCacheKey('v3', [])));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => '#GIRLBOSS',
            'description' => 'An online fashion retailer traces her path to success.',
            'contributor' => 'by Sophia Amoruso',
            'author' => 'Sophia Amoruso',
            'contributorNote' => '',
            'price' => 0,
            'ageGroup' => '',
            'publisher' => 'Portfolio/Penguin/Putnam',
        ]);
    }

    public function test_list_history_failed_with_incorrect_filter_types(): void
    {
        Http::preventStrayRequests();

        $response = $this->get(self::ROUTE.'?author=&isbn=9780671003548&title=&offset=');

        Http::assertNothingSent();

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'data' => [
                'message' => 'The given data was invalid.',
                'details' => [
                    'author' => [
                        'The author field must be a string.',
                    ],
                    'isbn' => [
                        'The ISBN field must be an array.',
                    ],
                    'title' => [
                        'The title field must be a string.',
                    ],
                    'offset' => [
                        'The offset field must be an integer.',
                    ],
                ],
            ],
        ]);
    }

    public function test_list_history_failed_with_incorrect_isbn_format(): void
    {
        Http::preventStrayRequests();

        $response = $this->get(self::ROUTE.'?isbn[]=111');

        Http::assertNothingSent();

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'data' => [
                'message' => 'The given data was invalid.',
                'details' => [
                    'isbn.0' => [
                        'ISBN must be 10 or 13 digit numeric string.',
                    ],
                ],
            ],
        ]);
    }

    public function test_list_history_failed_with_isbn_duplicate(): void
    {
        Http::preventStrayRequests();

        $response = $this->get(self::ROUTE.'?isbn[]=9780671003548&isbn[]=9780671003548');

        Http::assertNothingSent();

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'data' => [
                'message' => 'The given data was invalid.',
                'details' => [
                    'isbn.0' => [
                        'The ISBN field has a duplicate value.',
                    ],
                    'isbn.1' => [
                        'The ISBN field has a duplicate value.',
                    ],
                ],
            ],
        ]);
    }

    public function test_list_history_failed_with_incorrect_offset(): void
    {
        Http::preventStrayRequests();

        $response = $this->get(self::ROUTE.'?offset=10');

        Http::assertNothingSent();

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'data' => [
                'message' => 'The given data was invalid.',
                'details' => [
                    'offset' => [
                        'Offset must be integer multiple of 20.',
                    ],
                ],
            ],
        ]);
    }

    public function test_list_history_failed_due_to_books_api_error(): void
    {
        Http::fake([
            self::URL_TO_FAKE => Http::response(NYTimesResponseFixture::unauthorizedResponse(), Response::HTTP_UNAUTHORIZED),
        ]);

        $response = $this->get(self::ROUTE);

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertExactJson([
            'data' => [
                'message' => 'HTTP request to NYT Books API respond with error.',
                'details' => [
                    'fault' => [
                        'faultString' => 'Invalid ApiKey',
                        'detail' => [
                            'errorcode' => 'oauth.v2.InvalidApiKey',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
