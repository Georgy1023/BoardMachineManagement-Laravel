<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Board;
use App\User;
use App\LicenseCode;
use Response;
use App\StartupCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CodeController extends Controller
{
    protected $role;
    protected $user_name;
    
    public function __construct()
    {
        parent::__construct();       
        $this->middleware('auth');
    }

    public function checkRole(){
        $this->role = Auth::user()->role; 
        $this->user_name = Auth::user()->user_name;
    }

    public function showGenerateLicenseForm(Request $request){
        if(Auth::user()->role=="Customer" || Auth::user()->role=="Client") return view('error.license_not_support_error'); 
        if(empty($request->default_version_id) && empty($request->default_mac) && empty($request->default_request_key)){
            $default_version_id = "";
            $default_mac = "";
            $default_request_key = "";
        }
        else{
            $default_version_id = $request->default_version_id;
            $default_mac = $request->default_mac;
            $default_request_key = $request->default_request_key;
        }
        $this->checkRole();
        $current_license = Auth::user()->license;
        $current_startup = Auth::user()->startup;
        if($this->role=='Admin') $boards = Board::all()->where('activated',true)->toArray();
        elseif($this->role=='Master') $boards = Board::where('activated',true)->where('master',$this->user_name)->get()->toArray();
        elseif($this->role=='Customer') $boards = Board::where('activated',true)->where('customer',$this->user_name)->get()->toArray();
        elseif($this->role=='Client') $boards = Board::where('activated',true)->where('client',$this->user_name)->get()->toArray();
        return view('code.showGenerateLicenseForm',compact('boards','current_license','current_startup','default_version_id','default_mac','default_request_key'));
    }

    public function showGenerateStartupForm(Request $request){
        if(empty($request->default_startup)){
            $default_startup = "";
        }
        else{
            $default_startup = $request->default_startup;
        }
        $this->checkRole();
        $current_license = Auth::user()->license;
        $current_startup = Auth::user()->startup;
        if($this->role=='Admin') $boards = Board::all()->where('activated',true)->toArray();
        elseif($this->role=='Master') $boards = Board::where('activated',true)->where('master',$this->user_name)->get()->toArray();
        elseif($this->role=='Customer') $boards = Board::where('activated',true)->where('customer',$this->user_name)->get()->toArray();
        elseif($this->role=='Client') $boards = Board::where('activated',true)->where('client',$this->user_name)->get()->toArray();
        return view('code.showGenerateStartupForm',compact('boards','current_license','current_startup','default_startup'));
    }

    public function showAssignCodeForm(){
        if(Auth::user()->role=="Customer" || Auth::user()->role=="Client") return ;
        $users = User::where('parent_id', Auth::user()->id)->get()->toArray();
        $current_license_num = Auth::user()->license;
        $current_startup_num = Auth::user()->startup;
        $this->checkRole();
        if($this->role=="Admin") $childrole = "Masters";
        if($this->role=="Master") $childrole = "Customers";
        if($this->role=="Customer") $childrole = "Clients";
        return view('code.showAssignCodeForm',compact('users','childrole','current_license_num','current_startup_num'));
    }

    public function showAllCodes(){
        $this->checkRole();
        if($this->role=="Admin") {
            $license_codes = LicenseCode::all();
            $startup_codes = StartupCode::all();
        }
        else{
            $license_codes = LicenseCode::where('created_by',$this->user_name)->get()->toArray();
            $startup_codes = StartupCode::where('created_by',$this->user_name)->get()->toArray();
        }
        return view('code.showAllCodes',compact('license_codes','startup_codes'));
    }

    public function registerLicenseCode(Request $request){
        $this->checkRole();
        // $validator = Validator::make($request->all(), [
        //     'mac_address' => 'required',
        //     'note' => 'required',
        // ]);
        // if ($validator->fails())
        // {
        //     return redirect()->back()->withErrors($validator->messages())->withInput();
        // }

        $generated_license_code = "*License*";
        $mac_address = $request->mac_address;
        $version_id = $request->version_id;
        $request_key = $request->request_key;
        $note = $request->note;
        $board = Board::where('mac_address',$mac_address)->get();
        $board = $board[0];
        $license_item = new LicenseCode();
        $license_item->created_by=$this->user_name;
        $license_item->role=$this->role;
        $license_item->version_id=$version_id;
        $license_item->mac_address=$board->mac_address;
        $license_item->request_key=$request_key;
        $license_item->license=$generated_license_code;
        $license_item->note=$note;
        $license_item->save();

        $board->license_code_requested_num++;
        $board->version_id = $version_id;
        $board->request_key = $request_key;
        $currentTime = Carbon::now();
        $board->last_license_code_requested = $currentTime->toDateTimeString();  
        $board->update();

        if(Auth::user()->role!="Admin"){
            $user = User::find(Auth::user()->id);
            $user->license--;
            $user->update();
        }

        $data['generated_license_code'] = $generated_license_code;
        $data['current_license_num'] = Auth::user()->license-1;
        return $data;
    }

    public function registerStartupCode(Request $request){
        $this->checkRole();
        // $validator = Validator::make($request->all(), [
        //     'mac_address' => 'required',
        //     'startup_code' => 'required',
        //     'note' => 'required',
        // ]);
        // if ($validator->fails())
        // {
        //     return redirect()->back()->withErrors($validator->messages())->withInput();
        // }
        $generated_activation_code = "10231";
        $mac_address = $request->mac_address;
        $note = $request->note;
        $board = Board::where('mac_address',$mac_address)->get();
        $board = $board[0];
        $license_item = new StartupCode();
        $license_item->created_by=$this->user_name;
        $license_item->role=$this->role;
        $license_item->version_id=$board->version_id;
        $license_item->mac_address=$board->mac_address;
        $license_item->request_key=$board->request_key;
        $license_item->activation_code=$generated_activation_code;
        $license_item->startup_code = $request->startup_code;
        $license_item->note=$note;
        $license_item->save();

        $board->startup_code_requested_num++;
        $currentTime = Carbon::now();
        $board->last_startup_code_requested = $currentTime->toDateTimeString();  
        $board->update();

        if(Auth::user()->role!="Admin"){
            $user = User::find(Auth::user()->id);
            $user->startup--;
            $user->update();
        }

        $data['generated_activation_code'] = $generated_activation_code;
        $data['startup_count'] = Auth::user()->startup-1;
        return $data;
        // return redirect('code/showAllCodes');
    }

    public function  assignLicenseCode(Request $request){
        $this->checkRole();
        $validator = Validator::make($request->all(), [
            'license_select_user' => 'required',
            'license_num' => 'required',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->messages())->withInput();
        }   
        $user = $request->license_select_user;
        $num = $request->license_num;
        if(Auth::user()->role!="Admin"){
            $from = User::where('user_name',$this->user_name)->get();
            $from = $from[0];
            $from->license-=$num;
            $from->update();
        }
       $to = User::where('user_name',$user)->get();
       $to = $to[0];
       $to->license+=$num;
       $to->update();
       return back();
    }

    public function assignStartupCode(Request $request){
        $this->checkRole();
        $validator = Validator::make($request->all(), [
            'startup_select_user' => 'required',
            'startup_num' => 'required',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->messages())->withInput();
        }   
        $user = $request->startup_select_user;
        $num = $request->startup_num;
        $license_num = $request->license_num;

        if(Auth::user()->role!="Admin"){
            $from = User::where('user_name',$this->user_name)->get();
            $from = $from[0];
            $from->startup-=$num;
            $from->update();
        }
       $to = User::where('user_name',$user)->get();
       $to = $to[0];
       $to->startup+=$num;
       $to->license+=$license_num;
       $to->update();
       return back();
    }    

    public function exportCodeData(Request $request){
        $from = $request->from;
        $to = $request->to;
        if($from == "") $from = "2000-01-01";
        if($to == "") $to = "2100-01-01";
        $current_time = Carbon::now();
        $current_time = $current_time->toDateTimeString();

        
        $from_date = date_create($from);
        $formated_date1 = date_format($from_date,"Y-m-d H:i:s");

        $to_date = date_create($to);
        $formated_date2 = date_format($to_date,"Y-m-d H:i:s");

        $codes = LicenseCode::where('created_at','>=',$formated_date1)->where('created_at','<=',$formated_date2)->get();
        $startup_codes = StartupCode::where('created_at','>=',$formated_date1)->where('created_at','<=',$formated_date2)->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$current_time."_license_code_data.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $columns = array('Type','Id', 'Created By','Role','Version Id','Mac Address','Request Key','License Code','Startup Code','Activiation Code','Note','Created','Updated');
      
        $callback = function() use ($codes, $startup_codes,$columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($codes as $board) {
                fputcsv($file, array("License Code",$board->id,$board->created_by,$board->role,$board->version_id,$board->mac_address,$board->request_key,
            $board->license,"","",$board->note,$board->created_at,$board->updated_at)); 
            }
            foreach($startup_codes as $board) {
                fputcsv($file, array("Startup Code",$board->id,$board->created_by,$board->role,$board->version_id,$board->mac_address,$board->request_key,
            "",$board->startup_code,$board->activation_code,$board->note,$board->created_at,$board->updated_at));
            }
            fclose($file);  
        };

        return Response::stream($callback, 200, $headers);
    }
}