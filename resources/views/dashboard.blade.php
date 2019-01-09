@extends('layouts.layout')

@push('header-style')
<style>
    #codes_count_text h3{
        color:#14addb;
    }
    #user-table_filter input[type="search"]{
            border:solid 1px lightblue;
    }
    #board-table_filter input[type="search"]{
            border:solid 1px lightblue;
    }
    #exampleModal.modal{
     text-align: center;
    }
    #exampleModal.modal::before {
        content: "";	  
        display: inline-block;
        height: 100%;	 
        margin-right: -4px;
        vertical-align: middle;
    }
    #exampleModal .modal-dialog {	
        display: inline-block;	
        text-align: left;	
        vertical-align: middle;
    }	
</style>
@endpush

@section('content')
<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li><a><i class="fa fa-home" aria-hidden="true"></i></li>
            <li ><a> {{__('app.dashboard')}} </a> </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.dashboard')}}</h4>

             <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list">
                <i class="material-icons">more_vert</i>
            </a>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <h5 class="modal-title col-md-8 col-sm-8 col-xs-8" id="exampleModalLabel">{{__('app.export_code')}}</h5>
                            <button style="padding-right:10px" type="button col-md-1 col-sm-1 col-xs-1" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <label for="from"> {{__('app.from_date')}} </label>
                        <input type="text" class="form-control" id="from">
                        <label for="to"> {{__('app.to_date')}} </label>
                        <input type="text" class="form-control" id="to">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.cancel')}}</button>
                        <button type="button" class="btn btn-primary" id="btn_export_code">{{__('app.export_code_data')}}</button>
                    </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->role=="Admin" || Auth::user()->role=="Master")
            <ul id="dr-list" class="dropdown-content">
                <li><a href="{{URL::to('/board/exportBoardData')}}"><i class="material-icons">subject</i>{{__('app.export_board_data')}}</a> </li>
                <li><a data-toggle="modal" data-target="#exampleModal"><i class="material-icons">subject</i>{{__('app.export_code_data')}}</a> </li>
            </ul>      
            @endif


            <div class="tz-2-main-com bot-sp-20">
                <div class="tz-2-main-1 tz-2-main-admin">
                    <div class="tz-2-main-2"> <img src="{{URL::to('/')}}/images/users/user.png" alt=""><span>{{__('app.all_users')}}</span>
                        <p>All the Lorem Ipsum generators on the</p>
                        <h2>{{$child_users_count}}</h2> </div>
                </div>
                @if(Auth::user()->role=="Admin")
                <div class="tz-2-main-1 tz-2-main-admin">
                    <div class="tz-2-main-2"> <img src="{{URL::to('/')}}/images/users/user.png"  alt=""><span>{{__('app.master')}}s</span>
                        <p>All the Lorem Ipsum generators on the</p>
                        <h2>{{$master_count}}</h2> </div>
                </div>
                @endif
                @if(Auth::user()->role=="Admin" || Auth::user()->role=="Master")
                <div class="tz-2-main-1 tz-2-main-admin">
                    <div class="tz-2-main-2"> <img src="{{URL::to('/')}}/images/users/user.png"  alt=""><span>{{__('app.customer')}}s</span>
                        <p>All the Lorem Ipsum generators on the</p>
                        <h2>{{$customer_count}}</h2> </div>
                </div>
                @endif
                <div class="tz-2-main-1 tz-2-main-admin">
                    <div class="tz-2-main-2"> <img src="{{URL::to('/')}}/images/users/user.png"  alt=""><span>{{__('app.client')}}s</span>
                        <p>All the Lorem Ipsum generators on the</p>
                        <h2>{{$client_count}}</h2> </div>
                </div>
            </div>
            <div class="split-row">
                    <div class="row">
                        <div class="text-center" id="codes_count_text">
                            <div class="col-md-6">
                                @if(Auth::user()->role=="Admin") 
                                    <h3 style="padding-top:10px" class="col-md-6"> License Codes Available :- </h3> 
                                    <h3 style="padding-top:10px;" class="col-md-6"> Startup Codes Available :- </h3>
                                @endif
                                @if(Auth::user()->role=="Master")
                                    <h3 style="padding-top:10px" class="col-md-6"> {{__('app.license_codes_available')}}:{{Auth::user()->license}} </h3> 
                                    <h3 style="padding-top:10px;" class="col-md-6"> {{__('app.startup_codes_available')}}:{{Auth::user()->startup}} </h3>
                                @endif
                                @if(Auth::user()->role=="Customer" || Auth::user()->role=="Client")
                                    <h3 style="padding-top:10px;"> {{__('app.startup_codes_available')}}:{{Auth::user()->startup}} </h3>
                                @endif
                                @php
                                    $boards_count = count($boards);
                                    $not_assigned_boards_count = $boards_count-$assigned_board_count;
                                @endphp
                            </div>
                            <div class="col-md-6">
                                <h3 style="padding-top:10px;" class="col-md-6"> {{__('app.assigned_boards')}}: {{$assigned_board_count}}({{$boards_count}})</h3>
                                <h3 style="padding-top:10px;" class="col-md-6"> {{__('app.not_assigned')}}: {{$not_assigned_boards_count}}({{$boards_count}})</h3>
                            </div>
                        </div>
                    </div>
                <!--== Country Campaigns ==-->
                <div class="col-md-6">
                    <div class="box-inn-sp">
                        <div class="inn-title">
                            <h4>{{__('app.child_users_and_codes_left')}}</h4>
                            <!-- Dropdown Structure -->
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table id="user-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            @if(Auth::user()->role=="Admin")
                                                <th>Master Users</th>
                                                <th>License Codes Left</th>
                                            @endif
                                            @if(Auth::user()->role=="Master")
                                                <th>Customer Users</th>
                                            @endif
                                            @if(Auth::user()->role=="Customer")
                                                <th>Client Users</th>
                                            @endif
                                            <th>{{__('app.startup_codes_left')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($child_users as $item)
                                        <tr>
                                            <td> {{$item['user_name']}} </td>
                                            @if(Auth::user()->role=="Admin")
                                            <td> {{$item['license']}} </td>
                                            @endif
                                            <td> {{$item['startup']}} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--== Country Campaigns ==-->
                <div class="col-md-6">
                    <div class="box-inn-sp">
                        <div class="inn-title">
                            <h4>{{__('app.boards')}}</h4>
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table id="board-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{__('app.mac_address')}}</th>
                                            <th>{{__('app.assigned_user')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($boards as $board)
                                        <tr>
                                            <td> {{$board['mac_address']}} </td>
                                            @if(Auth::user()->role=="Admin")
                                            <td> {{$board['master']}} </td>
                                            @endif
                                            @if(Auth::user()->role=="Master")
                                            <td> {{$board['customer']}} </td>
                                            @endif
                                            @if(Auth::user()->role=="Customer")
                                            <td> {{$board['client']}} </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
<script>
    jQuery(function(){
        $("#user-table").DataTable({
            "pageLength": 10
        });
        $("#board-table").DataTable({
            "pageLength": 10
        });     

        
        $('#from').datepicker({
            format: 'yyyy/mm/dd',
            todayHighlight: true,
            autoclose: true,
        });
        $('#to').datepicker({
            format: 'yyyy/mm/dd',
            todayHighlight: true,
            autoclose: true,
        });
        $('#btn_export_code').click(function(){
            var from = $('#from').val();
            var to = $('#to').val();
            // ?from=2018%2F05%2F10&to=2018%2F06%2F01
            $url = baseUrl+'/code/exportCodeData'+"?from="+from+"&to="+to;
            window.location.href = $url;
            // $.ajax({
            //         url:baseUrl+'/code/exportCodeData',
            //         type:'get',
            //         data:{
            //             from:from,
            //             to:to                    
            //         }
            // });
        });
    });
</script>
@endpush