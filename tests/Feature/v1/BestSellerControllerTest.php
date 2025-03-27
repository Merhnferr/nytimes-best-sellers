<?php

declare(strict_types=1);

namespace Tests\Feature\v1;

use App\Helpers\CacheHelper;
use Generator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\DataFixtures\NYTimesResponseFixture;
use Tests\TestCase;

class BestSellerControllerTest extends TestCase
{
    private string $appRoute;

    private string $booksApiRouteToFake;

    protected function setUp(): void
    {
        parent::setUp();

        $this->appRoute = route('best-sellers.history', absolute: false);
        $this->booksApiRouteToFake = sprintf(
            '%s%s%s*',
            config('booksApi.baseUrl'),
            config('booksApi.defaultVersion'),
            config('booksApi.endpoints.v3.lists.bestSellersHistory'),
        );
    }

    protected function tearDown(): void
    {
        Cache::flush();

        parent::tearDown();
    }

    public static function invalidFiltersDataProvider(): Generator
    {
        yield 'invalid data types' => [
            [
                'author' => '',
                'isbn' => '9780671003548',
                'title' => '',
                'offset' => '',
            ],
            [
                'author' => ['The author field must be a string.'],
                'isbn' => ['The ISBN field must be an array.'],
                'title' => ['The title field must be a string.'],
                'offset' => ['The offset field must be an integer.'],
            ],
        ];

        yield 'invalid isbn string' => [
            [
                'isbn' => ['039916927A'],
            ],
            [
                'isbn.0' => ['ISBN must be valid isbn-10 or isbn-13 string.'],
            ],
        ];

        yield 'isbn duplicates' => [
            [
                'isbn' => ['0062273124', '0062273124'],
            ],
            [
                'isbn.0' => ['The ISBN field has a duplicate value.'],
                'isbn.1' => ['The ISBN field has a duplicate value.'],
            ],
        ];

        yield 'invalid offset' => [
            [
                'offset' => 10,
            ],
            [
                'offset' => ['Offset must be integer multiple of 20.'],
            ],
        ];
    }

    public function test_list_history_successful(): void
    {
        Http::fake([$this->booksApiRouteToFake => Http::response(NYTimesResponseFixture::okResponse())]);

        $response = $this->get($this->appRoute);

        $this->assertTrue(
            Cache::has(
                CacheHelper::buildCacheKey(config('booksApi.defaultVersion'), [])
            )
        );

        $response->assertStatus(Response::HTTP_OK);
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

    /**
     * @dataProvider invalidFiltersDataProvider
     */
    public function test_list_history_failed_filters_validation(array $filters, array $expectedDetails): void
    {
        Http::preventStrayRequests();

        $response = $this->get(sprintf('%s?%s', $this->appRoute, http_build_query($filters)));

        Http::assertNothingSent();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'data' => [
                'message' => 'The given data was invalid.',
                'details' => $expectedDetails,
            ],
        ]);
    }

    public function test_list_history_failed_due_to_books_api_error(): void
    {
        Http::fake([
            $this->booksApiRouteToFake => Http::response(
                NYTimesResponseFixture::unauthorizedResponse(),
                Response::HTTP_UNAUTHORIZED
            ),
        ]);

        $response = $this->get($this->appRoute);

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
