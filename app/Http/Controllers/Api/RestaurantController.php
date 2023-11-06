<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Restaurant;
use App\Models\Type;

class RestaurantController extends Controller
{
    public function index()
    {
        $query = request()->query();

        //se la querystring è settata ed è diversa da '' allora parte il filtro
        if (isset($query) && $query != []) {
            $queryString = explode(',', $query['search']);

            if (Type::where('name', $queryString)->exists()) {
                //FILTRO SBAGLIATO TENUTO PER RICORDO :)
                // $typeToSearch = [];

                // for ($i=0; $i < count($queryString); $i++) { 
                //     array_push($typeToSearch, Type::where('name', $queryString[$i])->get()->first());
                // }
                // dump($typeToSearch);

                // for ($i=0; $i < count($typeToSearch); $i++) { 
                //     if ($typeToSearch[$i]->restaurants) {
                //         $relatedRestaurants = $typeToSearch[$i]->restaurants;
                //     }
                // }
                //$relatedRestaurants = $typeToSearch->restaurants;

                $typeToSearch = Type::where('name', $queryString)->get()->first();

                $relatedRestaurants = $typeToSearch->restaurants;
            }

            return response()->json([
                'results' => $relatedRestaurants,
                'count' => $relatedRestaurants->count(),
            ]);
        }

        $restaurants = Restaurant::with([
            'user', 'types', 'dishes', 'dishes.category',
            'dishes.orders', 'orders'
        ])->get();

        return response()->json([
            'results' => $restaurants,
            'count' => $restaurants->count(),
        ]);
    }

    public function show($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->with(['user', 'types', 'dishes', 'dishes.category', 'dishes.orders', 'orders'])
            ->first();

        if (!$restaurant) {
            abort(404);
        }

        return response()->json($restaurant);
    }
}