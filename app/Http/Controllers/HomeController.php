<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Board;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $role;
    protected $user_name;
    public function __construct()
    {
        parent::__construct();       
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkRole(){
        $this->role = Auth::user()->role; 
        $this->user_name = Auth::user()->user_name;
    }
    public function index()
    {
        $this->checkRole();
        $data['user_name'] = $this->user_name;
        $data['role'] = $this->role;
        $customer_count = 0;
        $client_count = 0;
        if(Auth::user()->role=="Admin"){
            $boards = Board::all();
            $assigned_board_count = Board::where('master',"!=",null)->count();

            $child_users = User::where('parent_id',Auth::user()->id)->get()->toArray();
            $master_count = count($child_users);
            foreach($child_users as $master){
                $customers = User::where('parent_id',$master['id'])->get()->toArray();
                $customer_count += count($customers);
                foreach($customers as $customer){
                    $clients = User::where("parent_id",$customer['id'])->get()->toArray();
                    $client_count+= count($clients);
                }
            }
            $child_users_count =  $master_count + $customer_count+$client_count;
            return view('dashboard',compact('data','masters','master_count','customer_count','client_count','boards','child_users_count','child_users','assigned_board_count'));
        }

        if(Auth::user()->role=="Master"){
            $boards = Board::where('master',Auth::user()->user_name)->get()->toArray();
            $assigned_board_count = Board::where('master',Auth::user()->user_name)->where('customer',"!=",null)->count();
            $child_users = User::where('parent_id',Auth::user()->id)->get()->toArray();

            $customer_count = count($child_users);
            foreach($child_users as $customer){
                $clients = User::where("parent_id",$customer['id'])->get()->toArray();
                $client_count += count($clients);
            }
            $child_users_count = $customer_count+$client_count;
            return view('dashboard',compact('data','child_users','customer_count','client_count','boards','child_users_count','assigned_board_count'));
        }
        if(Auth::user()->role=="Customer"){
            $boards = Board::where('customer',Auth::user()->user_name)->get()->toArray();;
            $assigned_board_count = Board::where('customer',Auth::user()->user_name)->where('client',"!=",null)->count();
            $child_users = User::where('parent_id',Auth::user()->id)->get()->toArray();
            $child_users_count = count($child_users);
            $client_count = count($child_users);
            return view('dashboard',compact('data','child_users','client_count','boards','child_users_count','assigned_board_count'));
        }
        if(Auth::user()->role=="Client"){
            $this->checkRole();
            $current_license = Auth::user()->license;
            $current_startup = Auth::user()->startup;
            $boards = Board::where('client',$this->user_name)->get()->toArray();
            $assigned_board_count = 0;
            return view('code.showGenerateStartupForm',compact('boards','current_license','current_startup','assigned_board_count'));
        }
    }
    public function board(){
        $this->checkRole();
        $data['user_name'] = $this->user_name;
        $data['role'] = $this->role;
        
        return view($this->role.'.board',$data);
    }
}
