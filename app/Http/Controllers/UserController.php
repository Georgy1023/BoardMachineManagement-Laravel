<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
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

    public function showAddUser(){
        $this->checkRole();
        $role = $this->role;
        $addRole = "";
        if($role == "Admin"){
            $addRole = "Master";
        }        
        elseif($role=="Master"){
            $addRole = "Customer";
        }
        elseif($role == "Customer"){
            $addRole = "Client";
        }
        else{
            return back();
        }
        
        return view('user.user_add_form',compact('addRole'));
    }
    public function showSonList(){
        $this->checkRole();
        $role = $this->role;
        if($role=="Client") return back();
        $users = array();
        $user_id = Auth::user()->id;        
        $sonRole = "";
        switch ($role) {
            case "Admin":               
                $users = User::where('id','!=',$user_id)->get()->toArray();
                $sonRole = "Master";
                break;
            case "Master":
                $users = User::where('parent_id',$user_id)->get()->toArray();
                $sonRole = "Customer";
                break;
            case "Customer":
                $users = User::where('parent_id',$user_id)->get()->toArray();
                $sonRole = "Client";
                break;
        }
        $userModel = new User();
        return view('user.show_son_list',compact('users','userModel','sonRole'));
    }
    public function activateUser(Request $request){        
        $userId = $request->urserId;
        
        if($this->checkPossible($userId)== false) return false;
        $user = User::find($userId);
        $user->status = !$user->status;
        $user->save();
    }
    public function registerUser(Request $request){        

        $user_id = Auth::user()->id;

        if(empty($request->user_id)){
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|unique:users',
                'password'=>'required',
                'user_real_name'=>'required'
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|unique:users',
                'user_real_name'=>'required',
                'email' => 'unique:users',       
                'password'=>'required'
            ]);
        }
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->messages())->withInput();
            // The given data did not pass validation
        }
        
        $this->checkRole();
        $addRole = "";
        if($this->role == "Admin"){
            $addRole = "Master";
        }        
        elseif($this->role=="Master"){
            $addRole = "Customer";
        }
        elseif($this->role == "Customer"){
            $addRole = "Client";
        }
        if(empty($request->user_id)){
            $user = new User();
            $user->user_name = $request->input('user_name');
            $user->email =  $request->input('email');
            $user->phone =  $request->input('phone');
            $user->last_connection = "";
            $user->parent_id = $user_id;
            $user->role = $addRole;
            $user->note =  $request->input('note');
            $user->password = bcrypt($request->input('password'));
            $user->origin_password = $request->password;   
            $user->user_real_name = $request->user_real_name;     
            $user->save();
            return redirect('/user/showAllUser');
        }
        else{
            $user = User::find($request->user_id);
            $user->user_name = $request->input('user_name');
            $user->email =  $request->input('email');
            $user->phone =  $request->input('phone');
            $user->note =  $request->input('note');
            $user->password = bcrypt($request->input('password'));
            $user->origin_password = $request->password;        
            $user->user_real_name = $request->user_real_name;   
            $user->update();
            return redirect('/user/showAllUser');
        }       
    }

    public function showAllUser(){
        $this->checkRole();
        $role = $this->role;
        if($role=="Client") return back();
        $users = array();
        $user_id = Auth::user()->id;      
        switch ($role) {
            case "Admin":               
                $users = User::where('id','!=',$user_id)->get()->toArray();
                break;
            case "Master":
                $users = User::where('parent_id',$user_id)->get()->toArray();                
                foreach($users as $item){
                    $temp = User::where('parent_id',$item['id'])->get()->toArray();
                    foreach($temp as $t){
                        array_push($users,$t);
                    }
                }   
                break;
            case "Customer":
                $users = User::where('parent_id',$user_id)->get()->toArray();      
                break;
        }
        
        $userModel = new User();
        return view('user.show_all_user',compact('users','userModel'));
    }    

    public function deleteUser($id){

        User::where('parent_id',$id)->delete();
        User::find($id)->delete();                   
        return back();
    }

    public function showEditUserForm($id){
        $user = User::find($id);
        return view('user.show_edit_user',compact('user'));
    }

    public function showPasswordForm($id){
        $user = User::find($id);
        return view('user.change_password_form',compact('user'));
    }
    public function changePassword(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|confirmed',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->messages())->withInput();
        }

        $user = User::find($id);
        $user->password = bcrypt($request->new_password);
        $user->origin_password = $request->new_password;
        $user->update();
        return redirect('user/showSonList');
    }

    public function showProfile(){
        $user = User::find(Auth()->user()->id);
        return view('user.show_edit_user',compact('user'));
    }

    public function updateProfile(Request $request){
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [          
            'password'=>'required'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->messages())->withInput();
            // The given data did not pass validation
        }
        $user = User::find($request->user_id);
        // $user->user_name = $request->input('user_name');
        // $user->email =  $request->input('email');
        // $user->phone =  $request->input('phone');
        // $user->note =  $request->input('note');
        $user->password = bcrypt(trim($request->password));
        $user->origin_password = trim($request->password);        
        $user->update();
        return back();
    }
}
