<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Contractor;

class StatisticCallController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'statisticList' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('statistic.call.index');
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
        foreach ($users as $key => $user) {
            $users[$key] = array_merge($user, [
                'count_clients' => Contractor::countContractorsByManagerId($user['id']),
                'count_calls' => Task::countByManagerIdAndType($user['id'], 1),
                'count_meetings' => Task::countByManagerIdAndType($user['id'], 2),
                'count_actions' => Task::countByManagerIdAndType($user['id'], 3),
            ]);
        }

        return response()->json([
            'data' => $users,
        ]);
    }
}
