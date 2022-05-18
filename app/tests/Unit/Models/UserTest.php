<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testFavoriteMeals(): void
    {
        $model = new User();

        $this->assertInstanceOf(HasMany::class, $model->favoriteMeals());
    }
}
