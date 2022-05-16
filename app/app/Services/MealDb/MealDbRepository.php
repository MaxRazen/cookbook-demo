<?php

namespace App\Services\MealDb;

use App\Services\MealDb\Transformers\SearchResultTransformer;
use Illuminate\Support\Collection;

class MealDbRepository
{
    public function __construct(private MealDbApiClient $client)
    {
    }

    public function search(string $searchQuery): Collection
    {
        $results = $this->client->search($searchQuery);

        return (new SearchResultTransformer())
            ->transform(collect($results));
    }
}
