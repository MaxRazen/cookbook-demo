<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealItemResource;
use App\MealDb\MealDbRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController
{
    public function __invoke(Request $request): View
    {
        $search = trim($request->get('q', ''));

        $results = app(MealDbRepository::class)->search($search);

        return view('search', [
            'searchQuery' => $search,
            'results' => MealItemResource::collection($results, $request->user()),
        ]);
    }
}
