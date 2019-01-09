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



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(){
        $this->middleware('auth');
        
        $lang = session('lang');
        app()->setLocale($lang);
    }
    public function afterLogin(){
        
        $ip_address = \request()->ip();
        $position = Location::get($ip_address);

        
        if($position->countryCode !="es" && $position->countryCode !="de" && $position->countryCode !="ro") $lang="en";
        else {
            if($postion->countryCode == "at") $lang="de";
            $lang = $postion->countryCode;
        }
        session(['lang' => $lang]);


        $user_name = Auth::user()->user_name;
        $logged_users = User::where('user_name',Auth::user()->user_name)->get();      
        $logged_user = $logged_users[0];

        $currentTime = Carbon::now();
        $logged_user->last_connection = $currentTime->toDateTimeString();  
        $logged_user->update();        
        if(Auth::user()->status==false) return redirect('/user_deactivate_error');
        if(Auth::user()->status==true) return redirect('/dashboard');
    }

    public function checkPossible($childId){
        $myId = Auth::user()->id;                
        for($i=0;$i<5;$i++){
            if($myId == $childId) return true;
            if(User::find($childId)->count()>0){
                $childId = User::find($childId)->parent_id;
            }
        }        
        return false;
    }

    public function changeLanguage(Request $request){

        $lang = $request->language;
        session(['lang' => $lang]);
        Session::save();
        return back();
    }
}

