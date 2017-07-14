<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CityController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'cityList' => ['manager'],
        'citySave' => ['manager'],
        'cityDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('city.index');
    }

    public function cityList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => City::all(),
        ]);
    }

    public function citySave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'ext_id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        if (empty($request->id)) {
            $city = new City();
        } else {
            $city = City::where([
                    'id' => $request->id
                ])
                ->first();
        }

        if (empty($city)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $city->ext_id = $request->ext_id;
        $city->name = $request->name;
        $city->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function cityDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $city = City::where([
                'id' => $request->id
            ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
