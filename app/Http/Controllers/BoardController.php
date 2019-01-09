<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Response;
use Carbon\Carbon;
use App\Board;
use App\User;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
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
        
       
        return view($this->role.'.board',$data);
    }

    public function showAllBoards(){       
        $this->checkRole();
        $role = $this->role;
        $user_id = Auth::user()->id;      
        switch ($role) {
            case "Admin":               
                $boards = Board::get()->toArray();
                break;
            case "Master":
                $boards = Board::where('master',Auth::user()->user_name)->get()->toArray();                
                break;
            case "Customer":
                $boards = Board::where('customer',Auth::user()->user_name)->get()->toArray();      
                break; 
            case 'Client':
                $boards = Board::where('client',Auth::user()->user_name)->get()->toArray();
                break;
        }
        return view('board.show_all_boards',compact('boards'));
    }
    public function showRegisterBoard(){
        $childs = User::where('parent_id',Auth::user()->id)->get()->toArray();
        return view('board.show_rigister_board',compact('childs'));
    }
    public function registerBoard(Request $request){

        $validator = Validator::make($request->all(), [
            'mac_address' => 'required|unique:boards',
            'producer' => 'required',
            'startup_period'=>'required'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->messages())->withInput();
            // The given data did not pass validation
        }
        $board = new Board();
        $mac_address = $request->mac_address;
        $final_mac_address = str_replace(":","",$mac_address);
        $board->mac_address = $final_mac_address;
        $board->producer = $request->producer;
        $board->startup_period = $request->startup_period;
        //$board->sub_version = $request->sub_version;
        // $board->version_id = $request->version_id;
        $board->wibu_serial = $request->wibu_serial;
        // $board->request_key = $request->request_key;
        $board->note = $request->note;
        $board->save();
        return redirect('/board/showAllBoards');
    }

    public function showAssignBoard(Request $request){
        
        $this->checkRole();
        $role = $this->role;
        $user_id = Auth::user()->id;      
        switch ($role) {
            case "Admin":               
                $boards = Board::where('master',null)->get()->toArray();
                $child_name = "Master";
                break;
            case "Master":
                $boards = Board::where('customer',null)->where('master',Auth::user()->user_name)->get()->toArray();   
                $child_name = "Customer";             
                break;
            case "Customer":
                $boards = Board::where('client',null)->where('customer',Auth::user()->user_name)->get()->toArray(); 
                $child_name = "Client";     
                break;
            case 'Client':
                $boards = Board::where('client',Auth::user()->user_name)->get()->toArray();
                break;
        }
        $childs = User::where('parent_id',$user_id)->get()->toArray();
        return view('board.show_assign_board',compact('boards','child_name','childs'));
    }

    public function activateBoard(Request $request){
        $boardId = $request->boardId;                
        $board = Board::find($boardId);
        $board->activated = !$board->activated;
        $board->update();
    }
    public function deleteBoard($id){              
        Board::find($id)->delete();                   
        return back();
    }
    public function assignBoard(Request $request){
        
        $this->checkRole();
        $role = $this->role; 
        
        $selected_boards = $request->selected_boards;
        $user_name = $request->select_user;
        // $board_mac_address = $request->selected_board;

        
        foreach($selected_boards as $board_mac_address){
            $board = Board::where('mac_address',$board_mac_address)->get();
            $board = $board[0];
            if(Auth::user()->role=="Admin") $board->master=$user_name;
            if(Auth::user()->role=="Master") $board->customer=$user_name;
            if(Auth::user()->role=="Customer") $board->client=$user_name;
            $board->save();
        }

        return "success";

        // $count = User::where('parent_id',$user_id)->where('user_name',$child)->count();
        // if($count != 0)
        // {
        //     $board = Board::find($boardId);
        //     if($role=="Admin")
        //         $board->master = $child;
        //     if($role=="Master")
        //         $board->customer = $child;
        //     if($role=="Customer")
        //         $board->client = $child;   
        //     $board->update();
        //     return "yes";
        // }
        // else{
        //     $board = Board::find($boardId);
        //     if($role=="Admin")
        //         $board->master = '';
        //     if($role=="Master")
        //         $board->customer = '';
        //     if($role=="Customer")
        //         $board->client = '';   
        //     $board->update();
        //     return 'no';
        // }
    }

    public function assignStartupPeriod(Request $request){
        $periodValue = $request->periodValue;
        $boardId = $request->boardId;
        $board = Board::find($boardId);
        $board->startup_period = $periodValue;
        $board->update();
    }
    

    public function showReturnBoard(){
        $this->checkRole();
        $role = $this->role;
        $user_id = Auth::user()->id;      
        switch ($role) {
            case "Admin":               
                $boards = Board::where('master','!=',null)->get()->toArray();
                $child_name = "Master";
                break;
            case "Master":
                $boards = Board::where('customer','!=',null)->where('master',Auth::user()->user_name)->get()->toArray();   
                $child_name = "Customer";             
                break;
            case "Customer":
                $boards = Board::where('client','!=',null)->where('customer',Auth::user()->user_name)->get()->toArray(); 
                $child_name = "Client";     
                break;
            case 'Client':
                $boards = Board::where('client',Auth::user()->user_name)->get()->toArray();
                break;
        }
        return view('board.show_return_board',compact('boards'));
    }
    
    public function returnBoard(Request $request){
        $selected_boards = $request->selected_boards;
        foreach($selected_boards as $mac_address){
            if(Auth::user()->role=="Admin"){
                $board = Board::where('mac_address',$mac_address)->get();
                $board = $board[0];
                $board -> master = null;
                $board -> customer = null;
                $board -> client = null;
                $board -> update();
            }
            if(Auth::user()->role=="Master"){
                $board = Board::where('mac_address',$mac_address)->get()->toArray();
                $board = $board[0];
                $board -> customer = null;
                $board -> client = null;
                $board -> update();
            }
        }
        return "success";
    }

    
    public function exportBoardData(){
        $current_time = Carbon::now();
        $current_time = $current_time->toDateTimeString();
        $boards = Board::get();
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$current_time."_board_data.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $columns = array('Id', 'Mac Addresss','Producer','Startup Period','Sub Version','Version Id','Wibu Serial','Request Key',
        'License Code Requested Count','Last License Code Requested','Startup Code Requested Count','Last Starup Code Requested',
        'Assigned Master','Assigned Customer','Assigned Client','Note','Created','Updated');
    
        $callback = function() use ($boards, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach($boards as $board) {
                fputcsv($file, array($board->id, $board->mac_address,$board->producer,$board->startup_period,$board->sub_version,$board->version_id,$board->wibu_serial,$board->request_key,
                $board->license_code_requested_num,$board->last_license_code_requested,$board->startup_code_requested_num,$board->last_startup_code_requested,
                $board->master,$board->customer,$board->client,$board->note,$board->created_at,$board->updated_at));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}
