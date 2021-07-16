<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function show(Request $request)
    {
        $states=State::where('parent','=',$request->parent)->orderBy('name','ASC')->get();
        return json_decode($states);
    }

}
