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
        #user-table td{
            text-align:center;
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
                <a>
                    <i class="fa fa-home" aria-hidden="true"></i> User</a>
            </li>
            <li class="active-bre">
                <a > {{__('app.change_password')}}
                </a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>All Users</h4>
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list">
                <i class="material-icons">more_vert</i>
            </a>
            <ul id="dr-list" class="dropdown-content">
                <li>
                    <a href="{{URL::to('/user/showAddUser')}}">{{__('app.add_new_user')}}</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{URL::to('/user/showAllUser')}}"> {{__('app.show_child_users')}} </a>
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
                                            <th class="text-center">{{__('app.photo')}}</th>
                                            <th class="text-center">{{__('app.login')}}</th>
                                            <th class="text-center">{{__('app.name')}}</th>
                                            <th class="text-center">{{__('app.role')}}</th>
                                            <th class="text-center">{{__('app.email')}}</th>
                                            <th class="text-center">{{__('app.origin_password')}}</th>
                                            <th class="text-center">{{__('app.change_password')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $item)                                            
                                        <tr>                                            
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
                                            <td>
                                                {{$item['user_real_name']}}
                                            </td>
                                            <td><span class="label label-primary">{{$item['role']}}</span></td>
                                            <td>{{$item['email']}}</td>
                                            <td>{{$item['origin_password']}}</td>
                                            <td class="text-center">
                                                <a href="{{URL::to('user/changePassword')}}/{{$item['id']}}">
                                                    <button class="btn btn-danger">{{__('app.change_password')}}</button>
                                                </a>
                                            </td>
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
            $("#user-table").DataTable();
            $("#user-table_length").hide();                     
        });

    </script>
@endpush