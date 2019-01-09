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
                <a >
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.users')}}</a>
            </li>
            <li class="active-bre">
                <a > {{__('app.show_child_users')}}</a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.all_users')}}</h4>
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list">
                <i class="material-icons">more_vert</i>
            </a>
            <ul id="dr-list" class="dropdown-content">
                <li>
                    <a href="{{URL::to('/user/showAddUser')}}">{{__('app.add_new_user')}}</a>
                </li>
            </ul>
            <!-- Dropdown Structure -->
            <div class="split-row">
                <div class="col-md-12">
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">                            
                            <div class="table-responsive">                                         
                                <table id="user-table" class="table table-hover" width="100%">
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
                                            <th>{{__('app.delete')}}</th>
                                            <th>{{__('app.created_at')}} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $item)                                            
                                        <tr user-id="{{$item['id']}}">                                            
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
                                            <td>{{$userModel->find($item['parent_id'])->user_name}}</td>                                            
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
                                                    <span class="active-switch label label-success">{{__('app.activated')}}</span>
                                                @else
                                                    <span class="active-switch  label label-danger">{{__('app.deactivated')}}</span>
                                                @endif
                                            </td>
                                            <td>{{$item['last_connection']}}</td>
                                            <td>{{$item['note']}}</td>
                                            <td>
                                                <a href="{{URL::to('/user/deleteUser')}}/{{$item['id']}}">
                                                    <span id="user_delete" class="fa fa-trash"></span>
                                                </a>
                                            </td>
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
            $("#user-table").DataTable({
                "pageLength": 10
            });
            $("#user-table_length").hide();
            var activatedText = "{{__('app.activated')}}";
            var deactivatedText = "{{__('app.deactivated')}}";
            $(".active-switch").click(function(){
                $(this).toggleClass('label-success');
                $(this).toggleClass('label-danger');

                var value;
                if($(this).hasClass('label-success')){
                    $(this).text(activatedText);
                    value = "1";
                }
                else{
                    $(this).text(deactivatedText);
                    value = "0";
                }
                var userId = $(this).parents('tr').attr('user-id');
                $.ajax({
                    url:baseUrl+'/user/activateUser',
                    type:'get',
                    data:{
                        urserId:userId                       
                    }      
                });
            });            
        });

    </script>
@endpush