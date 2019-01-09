@extends('layouts.layout')

@push('header-style')
    <style>
        #user-table_filter input[type="search"]{
            border:solid 1px lightblue;
        }
        .active-switch{
            cursor:pointer;
        }
        #user_delete {
            cursor:pointer;
        }
        #user_edit {
            cursor:pointer;
        }
        #user-table{
            table-layout: auto;
        }
    </style>
@endpush

@section('content')
    <!--== BODY INNER CONTAINER ==-->
  
<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li>
                <a href="">
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.boards')}}</a>
            </li>
            <li class="active-bre">
                <a href=""> {{__('app.return_board')}}</a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>Return Boards</h4>
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list">
                <i class="material-icons">more_vert</i>
            </a>
            <ul id="dr-list" class="dropdown-content">
                <li><a href="{{URL::to('/board/showAllBoards')}}"><i class="material-icons">subject</i>{{__('app.show_all_boards')}}</a> </li>
                @if(Auth::user()->role=="Admin")
                <li><a href="{{URL::to('/board/showRegisterBoard')}}"><i class="material-icons">subject</i>{{__('app.register_board')}}</a> </li>
                @endif
                @if(Auth::user()->role!="Client")
                <li><a href="{{URL::to('/board/showAssignBoard')}}"><i class="material-icons">subject</i>{{__('app.assign_boards')}}</a> </li>
                @endif
                <!-- <li><a href=""><i class="material-icons">play_for_work</i>Download</a> </li> -->
            </ul>      
            <button style="float:right;margin-right: 30px;" class="btn btn-success row" id="btn_return"> {{__('app.return_board')}} </button>
            <!-- Dropdown Structure -->
            <div class="split-row">
                <div class="col-md-12">
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">                            
                            <div class="table-responsive">                                         
                                <table id="user-table" class="table table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{__('app.mac_address')}}</th>
                                            <th>{{__('app.producer')}}</th>
                                            <th>{{__('app.startup_period')}}</th>
                                            <th>{{__('app.sub_version')}}</th>
                                            <th>{{__('app.version_id')}}</th>
                                            <th>{{__('app.activated')}}</th>
                                            <th>{{__('app.wibu_serial')}}</th>
                                            <th>{{__('app.request_key')}}</th>
                                            <th>{{__('app.license_code_requested_num')}}</th>
                                            <th>{{__('app.last_license_code_requested')}}</th>
                                            <th>{{__('app.startup_code_requested_num')}}</th>
                                            <th>{{__('app.last_startup_code_requested')}}</th>
                                            <th>{{__('app.assign_Master')}}</th>
                                            <th>{{__('app.assign_Customer')}}</th>
                                            <th>{{__('app.assign_Client')}}</th>
                                            <th>{{__('app.note')}}</th>
                                            <th>{{__('app.created_at')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                        @foreach($boards as $item)
                                        <tr id="{{$item['mac_address']}}"> 
                                            <td>{{$item['mac_address']}}</span></td>        
                                            <td>{{$item['producer']}}</span></td>
                                            <td>
                                                @if($item['startup_period']==0)OFF
                                                @else{{$item['startup_period']}}days
                                                @endif
                                            </td>
                                            <td>{{$item['sub_version']}}</span></td>
                                            <td>{{$item['version_id']}}</span></td>
                                            <td>
                                                @if($item['activated'] == 1)
                                                    <span class="active-switch label label-success">{{__('app.activated')}}</span>
                                                @else($item['activated'] == 0)
                                                    <span class="active-switch label label-danger">{{__('app.deactivated')}}</span>
                                                @endif
                                            </td>
                                            <td>{{$item['wibu_serial']}}</td>
                                            <td>{{$item['request_key']}}</td>
                                            <td>{{$item['license_code_requested_num']}}</td>
                                            <td>{{$item['last_license_code_requested']}}</td>
                                            <td>{{$item['startup_code_requested_num']}}</td>
                                            <td>{{$item['last_startup_code_requested']}}</td>
                                            <td>{{$item['master']}}</td>
                                            <td>{{$item['customer']}}</td>
                                            <td>{{$item['client']}}</td>
                                            <td>{{$item['note']}}</td>         
                                            <td>{{$item['created_at']}}</td>
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
            var selected_boards = [];

            $("#user-table").DataTable({    
                "pageLength": 10
            });
            
            $("#user-table").on("click",".table-body tr",function(){
                var mac_address = $(this).attr('id');
                
                
                // $('#selected_board').val(mac_address);
                // $('.table-body').find('td').removeClass('bg-success');
                if($(this).find('td').hasClass('bg-success')){
                    selected_boards = jQuery.grep(selected_boards, function(value) {
                        return value != mac_address;
                    });
                }
                else{
                    selected_boards.push(mac_address);
                }

                console.log(selected_boards);
                $(this).find('td').toggleClass('bg-success');
            });  

              

            $('#btn_return').click(function(e){
               
                if(selected_boards.length!=0){  
                    $.ajax({
                        url:baseUrl+'/board/returnBoard',
                        type:'post',
                        data:{
                            selected_boards:selected_boards                 
                        },
                        success:function(response){
                            if(response=="success"){
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });

    </script>
@endpush