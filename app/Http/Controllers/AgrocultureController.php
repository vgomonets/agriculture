<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agroculture;
use App\Models\Agrorotation;

class AgrocultureController extends Controller
{
    protected $access = [
        'agrocultureList' => ['manager'],
        'agrocultureDelete' => ['manager'],
    ];

    public function agrocultureList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return response()->json([
            'data' => Agroculture::where(function($query) use($request) {
                    if(!empty($request->company_id)) {
                        $query->where('company_id', $request->company_id);
                        $query->orWhereNull('company_id');
                    }
                })
                ->get(),
        ]);
    }
    
    public function agrocultureDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        Agroculture::whereIn('id', $request->id)
            ->delete();
        Agrorotation::whereIn('agroculture_id', $request->id)
            ->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
