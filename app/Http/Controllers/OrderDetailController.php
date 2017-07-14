<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\OrderDetail;
use App\Models\Role;
use App\Models\Nomenclatura;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class OrderDetailController extends Controller
{
    protected $access = [
        'index' => ['manager'],
        'orderDetailList' => ['manager'],
        'orderDetailSave' => ['manager'],
        'orderDetailDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('order_detail.index', [
            'order_id' => $request->order_id,
            'nomenclaturas' => Nomenclatura::all(),
        ]);
    }

    public function orderDetailList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return response()->json([
            'data' => OrderDetail::with(['nomenclatura'])
                ->where(['order_id' => $request->order_id])
                ->get(),
        ]);
    }

    public function orderDetailSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
                // 'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }

        if (empty($request->id)) {
            $order_detail = new OrderDetail();
            $order_detail->unguard();
            $order_detail->create(Input::except('_token'));
        } else {
            $order_detail = OrderDetail::where(['id' => $request->id])
                ->first();
            $order_detail->unguard();
            $order_detail->update(Input::except('_token'));
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function orderDetailDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $order_detail = OrderDetail::where([
            'id' => $request->id,
        ])->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
