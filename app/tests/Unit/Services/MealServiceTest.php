<?php

namespace Tests\Unit\Services;

use App\MealDb\MealDbRepository;
use App\MealDb\Transformers\SearchResultTransformer;
use App\Models\FavoriteMeal;
use App\Models\User;
use App\Services\MealService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\Mixins\InteractWithMealDbEntities;
use Tests\TestCase;

class MealServiceTest extends TestCase
{
    use InteractWithMealDbEntities;

    private ?MealService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new MealService();
    }

    public function testFavorite(): void
    {
        Event::fake();

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
        Event::fake();

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

    public function testFavoriteMealIngredients(): void
    {
        $favoriteMeals = collect([
            new FavoriteMeal([
                'user_id' => 1,
                'meal_id' => 1122,
            ]),
            new FavoriteMeal([
                'user_id' => 1,
                'meal_id' => 2233,
            ]),
        ]);

        $meals = (new SearchResultTransformer())
            ->transform(collect($this->mealsDataProvider()));

        $user = Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')
            ->with('favoriteMeals')
            ->andReturn($favoriteMeals);

        $repository = Mockery::mock(MealDbRepository::class);
        $repository->shouldReceive('find')
            ->twice()
            ->andReturn($meals->first(), $meals->last());

        $ingredients = $this->service->favoriteMealIngredients($user, $repository);
        $unique = array_keys(array_flip($ingredients));

        $this->assertNotEmpty($ingredients);
        $this->assertEquals($unique, $ingredients);
    }
}
