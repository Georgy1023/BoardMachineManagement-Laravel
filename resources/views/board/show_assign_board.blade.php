@extends('layouts.layout')

@push('header-style')
    <style>
        #user-table_filter input[type="search"]{
            border:solid 1px lightblue;
        }
        #user-table1_filter input[type="search"]{
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
        .caret{
            display:none;
        }
        td input{
            width:100px;
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
                <a href=""> {{__('app.assign_boards')}} </a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">;
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.assign_boards')}}</h4>
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list">
                <i class="material-icons">more_vert</i>
            </a>
            <ul id="dr-list" class="dropdown-content">
                <li><a href="{{URL::to('/board/showAllBoards')}}"><i class="material-icons">subject</i>{{__('app.show_all_boards')}}</a> </li>
                @if(Auth::user()->role=="Admin")
                    <li><a href="{{URL::to('/board/showRegisterBoard')}}"><i class="material-icons">subject</i>{{__('app.register_board')}}</a> </li>
                @endif
                @if(Auth::user()->role=="Admin" || Auth::user()->role=="Master")
                <li><a href="{{URL::to('/board/showReturnBoard')}}"><i class="material-icons">subject</i>{{__('app.return_board')}}</a> </li>
                @endif
            </ul>      
            <!-- Dropdown Structure -->
            <div class="split-row">
                <div class="col-md-12">
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">                            
                            <div class="table-responsive">      
                                <table id="user-table" class="table table-responsive table-hover" width="100%">
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
                                            <th>{{__('app.assign_'.$child_name)}}</th>
                                            <th>{{__('app.note')}}</th>
                                            <th>{{__('app.created_at')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                        @foreach($boards as $item)      
                                        <tr board-id="{{$item['id']}}" id="{{$item['mac_address']}}">
                                        <td>{{$item['mac_address']}}</span></td>        
                                        <td>{{$item['producer']}}</span></td>
                                        @if(Auth::user()->role=="Admin")
                                            <td>
                                            @php
                                                $period = array('30','60','90','0');
                                            @endphp
                                                <select class='startup_period_select' name="startup_period_select">                                                
                                                    @foreach($period as $p)
                                                        @if($p == '0') 
                                                            @php
                                                                $temp = 'OFF';
                                                            @endphp 
                                                        @else
                                                            @php 
                                                                $temp = $p." days";
                                                            @endphp
                                                        @endif
                                                        @if($p == $item['startup_period'])
                                                            <option value="{{$p}}" selected>{{$temp}}</option>
                                                        @else
                                                            <option value="{{$p}}">{{$temp}}</option>
                                                        @endif
                                                    @endforeach 
                                                </select>
                                            </td>
                                        @else
                                            <td>{{$item['startup_period']}}days</td>
                                        @endif
                                        <td>{{$item['sub_version']}}</span></td>
                                        <td>{{$item['version_id']}}</span></td>
                                        <td>
                                            @if($item['activated'] == 1)
                                                <span class="label label-success">{{__('app.activated')}}</span>
                                            @else($item['activated'] == 0)
                                                <span class="label label-danger">{{__('app.deactivated')}}</span>
                                            @endif
                                        </td>
                                        <td>{{$item['wibu_serial']}}</span></td>
                                        <td>{{$item['request_key']}}</span></td>
                                        <td>{{$item['license_code_requested_num']}}</span></td>
                                        <td>{{$item['last_license_code_requested']}}</span></td>
                                        <td>{{$item['startup_code_requested_num']}}</span></td>
                                        <td>{{$item['last_startup_code_requested']}}</span></td>
                                        <!-- <td>
                                            @php $value =""; @endphp
                                            @if($child_name=="Master")
                                                @php $value=$item['master']; @endphp
                                            @elseif($child_name=="Customer")
                                                @php $value=$item['customer']; @endphp
                                            @elseif($child_name=="Client")
                                                @php $value=$item['client']; @endphp
                                            @endif
                                            <input style="width:150px !important;" value="{{$value}}" type="text" class="assign-to form-control" id="assign-to-{{$item['id']}}" name="assign_to">                                              
                                        </td> -->
                                        @php $value =""; @endphp
                                        @if($child_name=="Master")
                                            @php $value=$item['master']; @endphp
                                        @elseif($child_name=="Customer")
                                            @php $value=$item['customer']; @endphp
                                        @elseif($child_name=="Client")
                                            @php $value=$item['client']; @endphp
                                        @endif
                                        <td> {{$value}}</td>
                                        <td>{{$item['note']}}</span></td>                     
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
            <div class="split-row">
                <div class="col-md-12">
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">                            
                            <div class="table-responsive">                                         
                                <table id="user-table1" class="table table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{__('app.photo')}}</th>
                                            <th>{{__('app.login')}}</th>
                                            <th>{{__('app.name')}} </th>
                                            <th>{{__('app.email')}}</th>
                                            <th>{{__('app.origin_password')}}</th>
                                            <th>{{__('app.phone')}}</th>
                                            <th>{{__('app.parent')}}</th>
                                            <th>{{__('app.role')}}</th>
                                            <th>{{__('app.licence')}}</th>
                                            <th>{{__('app.startup')}}</th>
                                            <th>{{__('app.status')}}</th>
                                            <th>{{__('app.last_connection')}}</th>
                                            <th>{{__('app.note')}}</th>
                                            <!-- <th>{{__('app.edit')}}</th> -->
                                            <th>{{__('app.created_at')}} </th>
                                        </tr>
                                    </thead>
                                    <tbody class="user-table-body">
                                        @foreach($childs as $item)                                            
                                        <tr id="{{$item['user_name']}}">                                            
                                            <td>
                                                <span class="list-img">
                                                    @if($item['photo']==null)
                                                        <img src="{{URL::to('/')}}/images/users/avatar.png" alt="">
                                                    @else
                                                        <img src="{{URL::to('/')}}{{$item->photo}}" alt="">
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <span class="list-enq-name">{{$item['user_name']}}</span>                                                    
                                                </a>
                                            </td>
                                            <td>{{$item['user_real_name']}}</td>
                                            <td>{{$item['email']}}</td>
                                            <td>{{$item['origin_password']}}</td>
                                            <td>{{$item['phone']}}</td>
                                            <td>{{$item['parent_id']}}</td>                                            
                                            <td>
                                                <span class="label label-primary">{{$item['role']}}</span>
                                            </td>
                                            <td>
                                                <span class="label label-primary">{{$item['license']}}</span>
                                            </td>
                                            <td>
                                                <span class="label label-info">{{$item['startup']}}</span>
                                            </td>
                                            <td> 
                                                @if($item['status'] == 1)
                                                    <span class="label label-success">{{__('app.activated')}}</span>
                                                @else
                                                    <span class="label label-danger">{{__('app.deactivated')}}</span>
                                                @endif
                                            </td>
                                            <td>{{$item['last_connection']}}</td>
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
  
            <div class="split-row">
                <div class="col-md-12">
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">
                            <div class="hom-cre-acc-left hom-cre-acc-right">
                                <div class="">     
                                    <form style="height:500px">
                                        @csrf
                                        <div class="row">
                                            
                                            <div class="input-field col s12">
                                                <input disabled id="selected_board" name="selected_board" class="form-control" placeholder="{{__('app.selected_boards')}}">
                                            </div>

                                            <div class="input-field col s12">
                                                <input id="select_user" name="select_user" class="form-control" type="text" placeholder="{{__('app.select_user')}}">
                                            </div>
                                            <div class="input-field col s12"> 
                                                <button id="assign_board" class="waves-effect waves-light btn-large full-btn"> {{__('app.assign_boards')}}</button>
                                            </div>
                                        </div>
                                    </form> 
                                </div>
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
            $("#user-table1").DataTable({
                "pageLength": 10
            });
            $(".active-switch").click(function(){
                $(this).toggleClass('label-success');
                $(this).toggleClass('label-danger');
                
                var activatedText = "{{__('app.activated')}}";
                var deactivatedText = "{{__('app.deactivated')}}";
                var value;
                if($(this).hasClass('label-success')){
                    $(this).text(activatedText);
                    value = "1";
                }
                else{
                    $(this).text(deactivatedText);
                    value = "0";
                }
                var boardId = $(this).parents('tr').attr('board-id');
                console.log(boardId);
                $.ajax({
                    url:baseUrl+'/board/activateBoard',
                    type:'get',
                    data:{
                        boardId:boardId                       
                    }      
                });
            });              

            $('.startup_period_select').change(function(){
                var boardId = $(this).parents('tr').attr('board-id');
                var periodValue = $(this).val();
                if(periodValue == null || periodValue == '') return;
                $.ajax({
                    url:baseUrl+'/board/assignStartupPeriod',
                    type:'get',
                    data:{
                        boardId:boardId,
                        periodValue:periodValue
                    }
                });
            });
            
            var selected_boards = [];
            var data = {};
            var users = [];
            @foreach($childs as $child)
                data["{{$child['user_name']}}"]=null;
                users.push("{{$child['user_name']}}");
            @endforeach

            var board_data = {};
            var boards = [];
            @foreach($boards as $board)
                board_data["{{$board['mac_address']}}"]=null;
                boards.push("{{$board['mac_address']}}");
            @endforeach
            

            $("#select_user").autocomplete({
                data:data,
                limit: 8, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                    // Callback function when value is autcompleted.
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });
            
            // $("#selected_board").autocomplete({
            //     data:board_data,
            //     limit: 8, // The max amount of results that can be shown at once. Default: Infinity.
            //     onAutocomplete: function(val) {
            //         // Callback function when value is autcompleted.
            //     },
            //     minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            // });
            // $(".assign-to").change(function(){
            //     var child = $(this).val();
            //     var boardId = $(this).parents('tr').attr('board-id');
            //     var dom = $(this);
            //     $.ajax({
            //         url:baseUrl+'/board/assignBoard',
            //         type:'get',
            //         data:{
            //             boardId:boardId,
            //             child:child
            //         },
            //         success: function(response){
            //             if(response == "no")
            //                 dom.val("");
            //         }
            //     });
            // });   
            $('#assign_board').click(function(e){
                var selected_user = $('#select_user').val();
                var selected_board = $('#selected_board').val();
                var is1 = jQuery.inArray(selected_user,users);
                // var is2 = jQuery.inArray(selected_board,boards);
                
                if(is1<0){                    
                    alert("{{__('app.user_validation')}}");
                    // e.preventDefault();
                }
                if(selected_boards.length!=0){
                    $.ajax({
                        url:baseUrl+'/board/assignBoard',
                        type:'post',
                        data:{
                            select_user:selected_user,
                            selected_boards:selected_boards                 
                        },
                        success:function(response){
                            if(response=="success"){
                                window.location.reload();
                            }
                        }
                    });
                }
                // if(is2<0){
                //     alert('No board such mac address.');
                //     e.preventDefault();
                // }
            })
            $('#user-table').on("click",".table-body tr", function(){
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
                var selected_boards_string = "";
                for(var i=0;i<selected_boards.length;i++){
                    selected_boards_string += selected_boards[i]+" ";
                }
                $('#selected_board').val(selected_boards_string);
                console.log(selected_boards);
                $(this).find('td').toggleClass('bg-success');
            })   
            $('#user-table1').on("click",".user-table-body tr",function(){
                var user_name = $(this).attr('id');
   
                $('#select_user').val(user_name);
                $('.user-table-body').find('td').removeClass('bg-success');
                $(this).find('td').addClass('bg-success');
            })
        });
    </script>
@endpush