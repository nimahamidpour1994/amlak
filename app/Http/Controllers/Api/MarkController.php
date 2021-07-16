<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function store(Request $request)
    {
        // INFO FOR VIEW
        $mark=new Meta([
            'model'=>'Advertisment',
            'model_id'=>$request->advertisment,
            'unique'=>isset(Auth()->user()->mobile)  ? Auth()->user()->mobile : \Request::ip(),
            'value'=>isset(Auth()->user()->mobile)  ? Auth()->user()->mobile : \Request::ip(),
            'key'=>'bookmark'
        ]);
        try {
            $mark->save();
        } catch (Exception $exception) {
            return $exception->getCode();
        }
        return 'success';
    }
}
