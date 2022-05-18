<?php

namespace Tests\Feature\Http;

use App\Models\FavoriteMeal;
use App\Models\User;
use App\Services\MealService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MealFavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    private ?User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        app(MealService::class)->favorite('1122', $this->user);
    }

    public function testRequestAsGuest(): void
    {
        $this->post(route('meals.favorite', ['mealId' => '1122']))
            ->assertRedirect(route('login'));
    }

    public function testAddingMealToFavorites(): void
    {
        $this->actingAs($this->user);

        $this->post(route('meals.favorite', ['mealId' => '2233']))
            ->assertStatus(200);

        $this->assertDatabaseCount(FavoriteMeal::class, 2);
    }

    public function testAddingSameMealToFavorites(): void
    {
        $this->actingAs($this->user);

        $this->post(route('meals.favorite', ['mealId' => '1122']))
            ->assertStatus(200);

        $this->assertDatabaseCount(FavoriteMeal::class, 1);
    }
}
