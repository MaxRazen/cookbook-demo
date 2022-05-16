<?php

namespace Tests\Feature\Search;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\Mixins\InteractWithHttpClient;
use Tests\Mixins\InteractWithMealDbEntities;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    use InteractWithHttpClient;
    use InteractWithMealDbEntities;

    public function test_search_as_guest(): void
    {
        $this->get('/search?q=example')
            ->assertRedirect(route('login'));
    }

    public function test_search_as_user(): void
    {
        $this->actingAs(User::factory()->create());

        $this->mockHttpClient([
            new Response(200, [], json_encode(['meals' => $this->mealsDataProvider()])),
        ]);

        $meal = collect($this->mealsDataProvider())->first();
        $title = Arr::get($meal, 'strMeal');

        $this->get('/search?q=example')
            ->assertStatus(200)
            ->assertSee('example')
            ->assertSee($title);
    }
}
