<?php

namespace App\Services;

use App\Models\User;

class MealService
{
    public function favorite(string $mealId, User $user): void
    {
        $user->favoriteMeals()->firstOrCreate([
            'meal_id' => $mealId,
        ]);
    }

    public function removeFavorite(string $mealId, User $user): void
    {
        $user->favoriteMeals()
            ->where('meal_id', $mealId)
            ->delete();
    }
}
