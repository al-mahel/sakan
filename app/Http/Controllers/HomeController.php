<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\University;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $featured   = Property::active()->featured()->with(['images'])->latest()->take(6)->get();
        $latest     = Property::active()->with(['images'])->latest()->take(8)->get();
        $types      = Property::active()->distinct()->pluck('type');
        $cities     = Property::active()->distinct()->pluck('city')->filter();
        $totalCount = Property::active()->count();
        $universities = University::active()->limit(10)->get();

        return view('home.index', compact(
            'featured', 'latest', 'types', 'cities', 'totalCount', 'universities'
        ));
    }
}
