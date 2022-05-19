<?php

namespace Tests\Unit\Services;

use App\Models\FavoriteMeal;
use App\Models\User;
use App\Services\MealService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;
use Tests\TestCase;

class MealServiceTest extends TestCase
{
    private ?MealService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new MealService();
    }

    public function testFavorite(): void
    {
        $favoriteMeal = new FavoriteMeal();

        $relationMock = Mockery::mock(HasMany::class);
        $relationMock->shouldReceive('firstOrCreate')
            ->once()
            ->andReturn($favoriteMeal);

        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('favoriteMeals')
            ->once()
            ->andReturn($relationMock);

        $this->service->favorite('::id::', $userMock);
    }

    public function testRemoveFavorite(): void
    {
        $builder = Mockery::mock(Builder::class);
        $builder->shouldReceive('delete')
            ->andReturn(1);

        $relationMock = Mockery::mock(HasMany::class);
        $relationMock->shouldReceive('where')
            ->once()
            ->andReturn($builder);

        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('favoriteMeals')
            ->once()
            ->andReturn($relationMock);

        $this->service->removeFavorite('::id::', $userMock);
    }
}
