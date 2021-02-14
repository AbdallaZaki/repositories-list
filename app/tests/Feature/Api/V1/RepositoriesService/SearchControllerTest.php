<?php

namespace Tests\Feature\Api\V1\RepositoriesService;

use App\Services\GithuhServices\Contracts\SearchServiceInterface;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{

    public function testSearchGithubRepositoriesApiWithDefaultFilters()
    {
        $this->mock(SearchServiceInterface::class, function ($mock) {
            $mock->shouldReceive('search')->once()->andReturn(
               new Collection([
                   [
                    'id' => 1863329,
                    'stars' => 63855,
                    'url' => "https://github.com/laravel/laravel",
                    'ownerUrl' => "https://github.com/laravel",
                    'description' => "A PHP framework for web artisans",
                    'language' => "PHP",
                    'forks' => 20420
                   ]
               ])
            );
        });

        $response = $this->get(route('search.service'));

        $response->assertSuccessful();

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'stars',
                        'url',
                        'ownerUrl',
                        'description',
                        'language',
                        'forks'
                    ]
                ]
            ]
        );
    }


    public function testSearchGithubRepositoriesApiWithLanguageFilter()
    {
        $this->mock(SearchServiceInterface::class, function ($mock) {
            $mock->shouldReceive('search')->once()->andReturn(
                new Collection([
                    [
                        'id' => 28457823,
                        'stars' => 319674,
                        'url' => 'https://github.com/freeCodeCamp/freeCodeCamp',
                        'ownerUrl' => 'https://github.com/freeCodeCamp',
                        'description' => 'freeCodeCamp.org\'s open source codebase and curriculum. Learn to code for free.',
                        'language' => 'JavaScript',
                        'forks' => 25383,
                    ],
                    [
                        'id' => 11730342,
                        'stars' => 179376,
                        'url' => 'https://github.com/vuejs/vue',
                        'ownerUrl' => 'https://github.com/vuejs',
                        'description' => '🖖 Vue.js is a progressive, incrementally-adoptable JavaScript framework for building UI on the web.',
                        'language' => 'JavaScript',
                        'forks' => 28114,
                    ],
                    [
                        'id' => 10270250,
                        'stars' => 163641,
                        'url' => 'https://github.com/facebook/react',
                        'ownerUrl' => 'https://github.com/facebook',
                        'description' => 'A declarative, efficient, and flexible JavaScript library for building user interfaces.',
                        'language' => 'JavaScript',
                        'forks' => 32760,
                    ],
                    [
                        'id' => 2126244,
                        'stars' => 148206,
                        'url' => 'https://github.com/twbs/bootstrap',
                        'ownerUrl' => 'https://github.com/twbs',
                        'description' => 'The most popular HTML, CSS, and JavaScript framework for developing responsive, mobile first projects on the web.',
                        'language' => 'JavaScript',
                        'forks' => 72229,
                    ],
                    [
                        'id' => 6498492,
                        'stars' => 104600,
                        'url' => 'https://github.com/airbnb/javascript',
                        'ownerUrl' => 'https://github.com/airbnb',
                        'description' => 'JavaScript Style Guide',
                        'language' => 'JavaScript',
                        'forks' => 20334,
                    ],
                    [
                        'id' => 126577260,
                        'stars' => 96008,
                        'url' => 'https://github.com/trekhleb/javascript-algorithms',
                        'ownerUrl' => 'https://github.com/trekhleb',
                        'description' => '📝 Algorithms and data structures implemented in JavaScript with explanations and links to further readings',
                        'language' => 'JavaScript',
                        'forks' => 16088,
                    ]
                ])
            );
        });

        $response = $this->get(route('search.service',[
            'filter_by' => [
                'language' => 'javascript'
            ]
        ]));

        $response->assertSuccessful();

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'stars',
                        'url',
                        'ownerUrl',
                        'description',
                        'language',
                        'forks'
                    ]
                ]
            ]
        );

        $response->assertJsonFragment(['language' => 'JavaScript']);

        $response->assertJsonMissingExact(['language' => 'PHP']);
    }

    public function testSearchGithubRepositoriesApiWithForksSorter()
    {
        $this->mock(SearchServiceInterface::class, function ($mock) {
            $mock->shouldReceive('search')->once()->andReturn(
                new Collection([
                    [
                        'id' => 2126244,
                        'stars' => 148207,
                        'url' => 'https://github.com/twbs/bootstrap',
                        'ownerUrl' => 'https://github.com/twbs',
                        'description' => 'The most popular HTML, CSS, and JavaScript framework for developing responsive, mobile first projects on the web.',
                        'language' => 'JavaScript',
                        'forks' => 72229,
                    ],
                    [
                        'id' => 20042152,
                        'stars' => 1408,
                        'url' => 'https://github.com/nightscout/cgm-remote-monitor',
                        'ownerUrl' => 'https://github.com/nightscout',
                        'description' => 'nightscout web monitor',
                        'language' => 'JavaScript',
                        'forks' => 51132,
                    ],
                    [
                        'id' => 10270250,
                        'stars' => 163641,
                        'url' => 'https://github.com/facebook/react',
                        'ownerUrl' => 'https://github.com/facebook',
                        'description' => 'A declarative, efficient, and flexible JavaScript library for building user interfaces.',
                        'language' => 'JavaScript',
                        'forks' => 32760,
                    ],
                ])
            );
        });

        $response = $this->get(route('search.service',[
            'filter_by' => [
                'language' => 'javascript'
            ],
            'sort_by' =>'forks',
            'sort_direction' => 'desc'
        ]));

        $response->assertSuccessful();

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'stars',
                        'url',
                        'ownerUrl',
                        'description',
                        'language',
                        'forks'
                    ]
                ]
            ]
        );

        $response->assertJsonFragment(['language' => 'JavaScript']);

        $response->assertJsonMissingExact(['language' => 'PHP']);

        $repos = json_decode($response->getContent(),true)['data'];

        $this->assertEquals([72229,51132,32760],array_column($repos,'forks'),
        "assert that returned repositories sorted in desc direction same as static data");


    }

    public function testSearchGithubRepositoriesWithWrongQueryParams()
    {
        $response = $this->get(route('search.service',[
            'filter_by' => 'javascript',
            'sort_by' =>'forks',
            'sort_direction' => 'desc'
        ]));

        $response->assertStatus(422);
    }
}
