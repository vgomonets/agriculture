<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticMangerController extends Controller
{
    
    protected $access = [
        'index' => ['manager'],
        'statisticList' => ['manager'],
    ];

    public function index(Request $request)
    {
        return view('statistic.manager.index');
    }

    public function statisticList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $users = User::whereHas('roles', function($query) {
                $query->where('role_id', 4);
            })
            ->get()
            ->toArray();
        $stages = TaskStage::all();
        foreach ($users as $key => $user) {
            $users[$key]['stage'] = [];
            foreach ($stages as $stage) {
                $count = DB::table('tasks')->select(DB::raw('COUNT(*) as c'))
                    ->where([
                        'task_stage_id' => $stage->id,
                        'creator_id' => $user['id'],
                    ])
                    ->first();

                $users[$key]['stage'][$stage->id] = [
                    'count' => $count->c,
                ];
            }
        }

        return response()->json([
            'data' => $users,
        ]);
    }
}
