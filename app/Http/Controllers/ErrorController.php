<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Session;
use Location;



class ErrorController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(){
    }
   
    public function user_deactivate_error(){
        return view('error.user_deactivate_error');
    }

    public function license_not_support_error(){
        return view('error.license_not_support_error');
    }
}

