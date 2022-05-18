<?php

namespace App\MealDb;

use App\MealDb\Data\SearchResultItem;
use App\MealDb\Transformers\SearchResultTransformer;
use Illuminate\Support\Collection;

class MealDbRepository
{
    public function __construct(private MealDbApiClient $client)
    {
    }

    public function find(string $mealId): ?SearchResultItem
    {
        $results = $this->client->find($mealId);

        return (new SearchResultTransformer())
            ->transform(collect($results))
            ->first();
    }

    public function search(string $searchQuery): Collection
    {
        $results = $this->client->search($searchQuery);

        return (new SearchResultTransformer())
            ->transform(collect($results));
    }
}
