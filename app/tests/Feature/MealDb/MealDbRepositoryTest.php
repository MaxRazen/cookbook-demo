<?php

namespace Tests\Feature\MealDb;

use App\Services\MealDb\Data\SearchResultItem;
use App\Services\MealDb\MealDbApiClient;
use App\Services\MealDb\MealDbRepository;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\Mixins\InteractWithMealDbEntities;
use Tests\TestCase;

class MealDbRepositoryTest extends TestCase
{
    use InteractWithMealDbEntities;

    public function test_search_method(): void
    {
        $this->instance(
            MealDbApiClient::class,
            Mockery::mock(MealDbApiClient::class, function (MockInterface $mock): void {
                $mock->shouldReceive('search')
                    ->once()
                    ->andReturn($this->mealsDataProvider());
            }),
        );

        $repository = $this->app->make(MealDbRepository::class);

        $result = $repository->search('example');

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(SearchResultItem::class, $result->first());
    }
}
