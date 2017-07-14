<?php

namespace App\Http\Controllers;

use App\Models\AgrorotationDate;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AgrorotationDateController extends Controller
{
    protected $access = [
        'index' => ['manager'],
        'dateList' => ['manager'],
        'dateSave' => ['manager'],
        'dateDelete' => ['manager'],
    ];

    public function index(Request $request)
    {
        return view('agrorotation_date.index');
    }

    public function dateList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => AgrorotationDate::all(),
        ]);
    }

    public function dateSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        if (empty($request->id)) {
            $date = new AgrorotationDate();
        } else {
            $date = AgrorotationDate::where([
                'id' => $request->id
            ])
                ->first();
        }

        if (empty($date)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $date->date_from = $request->date_from;
        $date->date_to = $request->date_to;
        $date['date_from'] = date('Y-m-d', strtotime($date['date_from']));
        $date['date_to'] = date('Y-m-d', strtotime($date['date_to']));
        $date->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function dateDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $date = AgrorotationDate::where([
            'id' => $request->id
        ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
