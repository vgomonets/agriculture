<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderPayType;
use App\Models\Contractor;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\ContractorContacts;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'orderList' => ['manager'],
        'orderSave' => ['manager'],
        'orderDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('order.index', [
            'order_pay_types' => OrderPayType::all(),
            'contractors' => Contractor::all(),
            'users' => User::all(),
            'order_statuses' => OrderStatus::all(),
            //'contractor_contacts' => ContractorContacts::all(),
        ]);
    }

    public function orderList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return response()->json([
            'data' => Order::with(['orderPayType', 'orderStatus', 'contractor', 'user'])->get(),
        ]);
    }

    public function orderSave(Request $request)
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
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $data = Input::except(['_token', 'undefined' ]);

        if($data['contractor_type'] == 'contractor') {
            $data['contractor_type'] = 'App\Models\Contractor';
        } elseif ($data['contractor_type'] == 'company') {
            $data['contractor_type'] = 'App\Models\Company';
        }


        if(empty($request->id)) {
            $order = new Order();
            $order->unguard();
            $order->create($data);
        } else {
            $order = Order::where(['id' => $request->id])
                ->first();
            $order->unguard();
            $order->update($data);
        }



        return  response()->json([
            'success' => true,
        ]);
    }

    public function orderDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $order = Order::where([
                'id' => $request->id
            ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
