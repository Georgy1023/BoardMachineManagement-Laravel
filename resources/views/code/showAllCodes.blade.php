@extends('layouts.layout')

@push('header-style')
    <style>

        #license-table_filter input[type="search"]{
            border:solid 1px lightblue;
        }
        #startup-table_filter input[type="search"]{
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
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.code_management')}}</a>
            </li>
            <li class="active-bre">
                <a href=""> {{__('app.show_all_codes')}}</a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>All Boards</h4>
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list">
                <i class="material-icons">more_vert</i>
            </a>
            <ul id="dr-list" class="dropdown-content">
                @if(Auth::user()->role=="Admin" || Auth::user()->role=="Master")
                <li><a href="{{URL::to('/code/showGenerateLicenseForm')}}"><i class="material-icons">subject</i>{{__('app.generate_license_code')}}</a> </li>
                @endif
                <li><a href="{{URL::to('/code/showGenerateStartupForm')}}"><i class="material-icons">subject</i>{{__('app.generate_startup_code')}}</a> </li>
                @if(Auth::user()->role!="Client")
                <li><a href="{{URL::to('/code/showAssignCodeForm')}}"><i class="material-icons">subject</i>{{__('app.assign_codes')}}</a> </li>
                @endif
            </ul>      
            <!-- Dropdown Structure -->
            @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Master')
            <div class="split-row">
                <div class="col-md-12">
                    <h2 class="text-center" style="padding-top:10px; color:#14addb" class="btn-success"> {{__('app.license_codes_list')}} </h2>
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">                            
                            <div class="table-responsive">                                         
                                <table id="license-table" class="table table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{__('app.created_by')}} </th>
                                            <th>{{__('app.role')}} </th>
                                            <th>{{__('app.mac_address')}}</th>
                                            <th>{{__('app.version_id')}}</th>
                                            <th>{{__('app.request_key')}}</th>
                                            <th>{{__('app.note')}}</th>
                                            <th>{{__('app.license')}}</th>
                                            <th>{{__('app.created_at')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($license_codes as $item)
                                        <tr> 
                                            <td>{{$item['created_by']}}</td> 
                                            <td><span class="label label-primary">{{$item['role']}}</span></td>      
                                            <td>{{$item['mac_address']}}</td>
                                            <td>{{$item['version_id']}}</td>
                                            <td>{{$item['request_key']}}</td>
                                            <td>{{$item['note']}}</td>
                                            <th>{{$item['license']}}</th>
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
            @endif
            <div class="split-row">
                <div class="col-md-12">
                    <h2 class="text-center" style="padding-top:10px; color:#14addb;" class="btn-success"> {{__('app.startup_codes_list')}}</h2>
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">                            
                            <div class="table-responsive">                                         
                                <table id="startup-table" class="table table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{__('app.created_by')}} </th>
                                            <th>{{__('app.mac_address')}}</th>
                                            @if(Auth::user()->role=="Master" || Auth::user()->role=="Admin")
                                                <th>{{__('app.version_id')}}</th>
                                                <th>{{__('app.request_key')}}</th>
                                            @endif
                                            <th>{{__('app.startup_code')}}</th>
                                            <th>{{__('app.activation_code')}}</th>
                                            <th>{{__('app.note')}}</th>
                                            <th>{{__('app.created_at')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($startup_codes as $item)
                                        <tr> 
                                            <td>{{$item['created_by']}}</td>        
                                            <td>{{$item['mac_address']}}</td>
                                            @if(Auth::user()->role=="Master" || Auth::user()->role=="Admin")
                                                <td>{{$item['version_id']}}</td>
                                                <td>{{$item['request_key']}}</td>
                                            @endif
                                            <td>{{$item['startup_code']}}</td>
                                            <td>{{$item['activation_code']}}</td>
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
            $("#license-table").DataTable({
                "pageLength": 10
            });
            $('#startup-table').DataTable({
                "pageLength": 10
            });
        });

    </script>
@endpush