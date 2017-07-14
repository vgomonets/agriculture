<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class Controller extends BaseController
{
    protected $access = [];
    
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $action = explode('@', Route::getCurrentRoute()->getActionName());
        header('Cache-Control: no-cache;', true);
        
        if(empty($action[1]) || empty($this->access[$action[1]])) {
            Redirect::to('/login')->send();
            exit;
        } else {
            if(!in_array('?', $this->access[$action[1]])) {
                if(Auth::guest() 
                        /*|| !Role::userIsHaveRoles(Auth::user()->id, $this->access[$action[1]])*/) {
                    Redirect::to('/login')->send();
                    exit;
                }
            }
        }
    }
}
