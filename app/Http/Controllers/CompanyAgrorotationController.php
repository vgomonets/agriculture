<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agrorotation;
use App\Models\Agroculture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CompanyAgrorotationController extends Controller
{

    protected $access = [
        'agrorotationList' => ['manager'],
        'agrorotationSave' => ['manager'],
        'agrorotationDelete' => ['manager'],
    ];

    public function agrorotationList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        return  response()->json([
            'data' => Agrorotation::with(['unit', 'agroculture', 'chemical', 'user'])
                ->where([
                    'company_id' => $request->id,
                    'agrorotation_date_id' => $request->agrorotation_date_id,
                ])
                ->get(),
        ]);
    }

    public function agrorotationSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        $validator = Validator::make(Input::all(), [
            'data' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        
        // Удалить старые
        Agrorotation::where([
                'company_id' => $request->company_id,
                'agrorotation_date_id' => $request->agrorotation_date_id,
            ])
            ->delete();
        
        foreach((array) $request->data as $key => $item) {
            if(empty($item['agroculture_id']) || 
                    !$agroculture = Agroculture::find($item['agroculture_id'])) {
                $agroculture = new Agroculture();
                $agroculture->company_id = $request->company_id;
            }
            if(!empty($agroculture->company_id) && !empty($item['name'])) {
                $agroculture->name = $item['name'];
                $agroculture->save();
            }
            if(empty($agroculture)) {
                continue;
            }
            
            $agrorotation = new Agrorotation();
            $agrorotation->agrorotation_date_id = $request->agrorotation_date_id;
            $agrorotation->company_id = $request->company_id;
            $agrorotation->square = $item['square'];
            $agrorotation->comment = $item['comment'];
            $agrorotation->agroculture_id = $agroculture->id;
            $agrorotation->user_id = Auth::user()->id;
            $agrorotation->save();
        }
        
        return response()->json([
            'success' => true,
        ]);
    }

    public function agrorotationDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        Agrorotation::where(['id' => $request->id])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
