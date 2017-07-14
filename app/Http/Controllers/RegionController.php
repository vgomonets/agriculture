<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Region;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class RegionController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'regionList' => ['manager'],
        'regionSave' => ['manager'],
        'regionDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('region.index');
    }

    public function regionList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => Region::all(),
        ]);
    }

    public function regionSave(Request $request)
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
            $region = new Region();
        } else {
            $region = Region::where([
                    'id' => $request->id
                ])
                ->first();
        }

        if (empty($region)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $region->ext_id = $request->ext_id;
        $region->name = $request->name;
        $region->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function regionDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $region = Region::where([
                'id' => $request->id
            ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
