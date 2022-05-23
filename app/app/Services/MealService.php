<?php

namespace App\Services;

use App\Events\UserFavoriteListChanged;
use App\MealDb\Data\MealIngredientData;
use App\MealDb\MealDbRepository;
use App\Models\User;

class MealService
{
    public function favorite(string $mealId, User $user): void
    {
        $user->favoriteMeals()->firstOrCreate([
            'meal_id' => $mealId,
        ]);

        event(new UserFavoriteListChanged($user));
    }

    public function removeFavorite(string $mealId, User $user): void
    {
        $user->favoriteMeals()
            ->where('meal_id', $mealId)
            ->delete();

        event(new UserFavoriteListChanged($user));
    }

    public function favoriteMealIngredients(User $user, MealDbRepository $repository): array
    {
        $favoriteMealIds = $user->favoriteMeals->pluck('meal_id');

        $ingredients = collect();

        $favoriteMealIds->each(function (int $mealId) use ($ingredients, $repository): void {
            $meal = $repository->find((string) $mealId);

            if ($meal) {
                collect($meal->ingredients)->each(
                    fn (MealIngredientData $ingredient) => $ingredients->push($ingredient->name),
                );
            }
        });

        return $ingredients->unique()->all();
    }
}
