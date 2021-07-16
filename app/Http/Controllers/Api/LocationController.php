<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocationController extends Controller
{
    // in navbar when city change
    public function changeCity(Request $request)
    {

        if (isset($request->city))
        {
            if ($request->city!='')
            {
                $name='city';
                Cookie::queue($name, $request->city,43200);
                return 'success';
            }
        }
        return 'faild';
    }

    // when add advertisment when city change so the state need change
    public function changeState(Request $request)
    {
        $states=State::where('parent','=',$request->parent)->orderBy('name','ASC')->get();
        return json_decode($states);
    }

    // get lat and lng when city or state change
    public function getLocation(Request $request)
    {
        $postion=[];
        if (isset($request->type))
        {
            if ($request->type==1)
            {
                $city=City::firstWhere('id',$request->id);
                $postion['lat']=$city->latitude;
                $postion['lng']=$city->longitude;
            }
            else if ($request->type==2)
            {
                $state=State::firstWhere('id',$request->id);
                $postion['lat']=$state->latitude;
                $postion['lng']=$state->longitude;
            }

        }
        echo json_encode($postion);
    }
}
