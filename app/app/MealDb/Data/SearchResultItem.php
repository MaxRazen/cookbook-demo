<?php

namespace App\MealDb\Data;

use Spatie\DataTransferObject\DataTransferObject;

class SearchResultItem extends DataTransferObject
{
    public string $id;

    public string $title;

    public ?string $drink;

    public string $category;

    public string $country;

    public string $instruction;

    public ?string $imgUrl;

    public ?string $sourceUrl;

    /** @var array|MealIngredient[] */
    public array $ingredients = [];
}
