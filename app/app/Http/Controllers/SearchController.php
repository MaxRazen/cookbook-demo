<?php

namespace App\Http\Controllers;

use App\Services\MealDb\MealDbRepository;
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
            'results' => $results,
        ]);
    }
}
