<?php

namespace App\MealDb\Data;

use Spatie\DataTransferObject\DataTransferObject;

class MealIngredient extends DataTransferObject
{
    public string $name;

    public string $measure;
}
