@extends('layouts.layout')

@push('header-style')
    <style>
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
        #codes_count_text h3{
            color:#14addb;
        }
        .row_selected{
            border: 1px solid red;
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
                <a href=""> {{__('app.assign_codes')}} </a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.assign_codes')}} </h4>
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list">
                <i class="material-icons">more_vert</i>
            </a>
            <ul id="dr-list" class="dropdown-content">
                <li><a href="{{URL::to('/code/showAllCodes')}}"><i class="material-icons">subject</i>{{__('app.show_all_codes')}}</a> </li>
                @if(Auth::user()->role=="Admin" || Auth::user()->role=="Master")
                <li><a href="{{URL::to('/code/showGenerateLicenseForm')}}"><i class="material-icons">subject</i>{{__('app.generate_license_code')}}</a> </li>
                @endif
                <li><a href="{{URL::to('/code/showGenerateStartupForm')}}"><i class="material-icons">subject</i>{{__('app.generate_startup_code')}}</a> </li>
            </ul>        
            <!-- Dropdown Structure -->
            <div class="split-row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="text-center" id="codes_count_text">
                            @if(Auth::user()->role=="Admin") 
                                <h3 style="padding-top:10px" class="col-md-3"> {{__('app.license_codes_available')}}:--- </h3> 
                                <h3 style="padding-top:10px;" class="col-md-3"> {{__('app.startup_codes_available')}}:--- </h3>
                            @endif
                            @if(Auth::user()->role=="Master")
                                <h3 style="padding-top:10px" class="col-md-3"> {{__('app.license_codes_available')}}:{{Auth::user()->license}} </h3> 
                                <h3 style="padding-top:10px;" class="col-md-3">{{__('app.startup_codes_available')}}:{{Auth::user()->startup}} </h3>
                            @endif
                            @if(Auth::user()->role=="Customer" || Auth::user()->role=="Client")
                                <h3 style="padding-top:10px;" class="col-md-3"> {{__('app.startup_codes_available')}}:{{Auth::user()->startup}} </h3>
                            @endif
                        </div>
                    </div>
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">                            
                            <div class="table-responsive">                                         
                                <table id="startup-table" class="table table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Child {{$childrole}} </th>
                                            @if(Auth::user()->role=="Admin")
                                            <th>{{__('app.license_codes_left')}}</th>
                                            @endif
                                            <th>{{__('app.startup_codes_left')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                        @foreach($users as $item)
                                        <tr  class="row_selected" id="{{$item['user_name']}}">    
                                            <td>{{$item['user_name']}}</td>  
                                            @if(Auth::user()->role=="Admin")      
                                            <td class="license_count">{{$item['license']}}</td>
                                            @endif
                                            <td class="startup_count">{{$item['startup']}}</td>
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
                                    <!-- @if(Auth::user()->role=="Admin")   
                                    <form method="post" action="{{URL::to('/code/assignLicenseCode')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="license_select_user" name="license_select_user" value="{{ old('license_select_user')}}" type="text" class="form-control" placeholder="Select Child User">
                                                @if(!empty($errors->has('license_select_user')))
                                                    <span class="error">
                                                        {{$errors->first('license_select_user')}}
                                                    </span>
                                                @endif   
                                            </div>
                                            <div class="input-field col s12">
                                                <input id="license_num" name="license_num" value="{{ old('license_num')}}" type="number" class="validate">
                                                @if(!empty($errors->has('license_num')))
                                                    <span class="error">
                                                        {{$errors->first('license_num')}}
                                                    </span>
                                                @endif   
                                                <label for="license_num">License Num</label>
                                            </div>
                                            <div class="input-field col s12"> 
                                                <button id="assign_license_code"  type="submit" class="waves-effect waves-light btn-large full-btn"> Assign License Codes </button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif -->
                                    <form method="post" action="{{URL::to('/code/assignStartupCode')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="startup_select_user" name="startup_select_user" value="{{ old('startup_select_user')}}" type="text" class="form-control" placeholder="{{__('app.select_user')}}">
                                                @if(!empty($errors->has('startup_select_user')))
                                                    <span class="error">
                                                        {{$errors->first('startup_select_user')}}
                                                    </span>
                                                @endif   
                                            </div>
                                            @if(Auth::user()->role=="Admin")
                                            <div class="input-field col s12">
                                                <input id="license_num" name="license_num" value="{{ old('license_num')}}" type="number"  class="form-control" placeholder="{{__('app.license_codes_count')}}">
                                                @if(!empty($errors->has('license_num')))
                                                    <span class="error">
                                                        {{$errors->first('license_num')}}
                                                    </span>
                                                @endif   
                                            </div>
                                            @endif
                                            <div class="input-field col s12">
                                                <input id="startup_num" name="startup_num" value="{{ old('startup_num')}}" type="number"  class="form-control" placeholder="{{__('app.startup_codes_count')}}">
                                                @if(!empty($errors->has('startup_num')))
                                                    <span class="error">
                                                        {{$errors->first('startup_num')}}
                                                    </span>
                                                @endif   
                                            </div>
                                            <div class="input-field col s12"> 
                                                <button id="assign_startup_code"  type="submit" class="waves-effect waves-light btn-large full-btn"> @if(Auth::user()->role=="Admin") {{__('app.assign_codes')}} @else {{__('app.assign_startup_codes')}} @endif</button>
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
            $("#license-table").DataTable();
            $('#startup-table').DataTable();
            
            var count = {};
            count['license'] = {{$current_license_num}};
            count['startup'] = {{$current_startup_num}};
            var data = {};
            var users = [];
            @foreach($users as $user)
                data["{{$user['user_name']}}"]=null;
                users.push("{{$user['user_name']}}");
            @endforeach
                
            $("#license_select_user").autocomplete({
                data:data,
                limit: 8, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                    // Callback function when value is autcompleted.
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });

            $("#startup_select_user").autocomplete({
                data:data,
                limit: 8, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                    // Callback function when value is autcompleted.
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });

            $('#assign_license_code').click(function(e){
                var selected_user = $('#license_select_user').val();
                var is = jQuery.inArray( selected_user, users);
                var assign_num = $('#license_num').val();
                
                var new_selected_user = "#"+selected_user+" .license_count";
                var child_license = $(new_selected_user).text();
                var child_license_count = parseInt(child_license,10);
                count['child_license'] = $(new_selected_user)
                if(is<0){                    
                    alert("{{__('app.user_validation')}}");
                    e.preventDefault();
                }
                if(count['license']<assign_num)
                {
                    alert("{{__('app.not_enough_license_code1')}}");
                    e.preventDefault();
                }
                if(assign_num<0 && -1*assign_num>child_license_count){
                    alert("{{__('app.not_enough_license_code2')}}");
                    e.preventDefault();
                }
            });
            

            $('#assign_startup_code').click(function(e){
                var selected_user = $('#startup_select_user').val();
                var is = jQuery.inArray( selected_user, users);
                var assign_num = $('#startup_num').val();
                var assign_license_num = $('#license_num').val();

                var new_selected_user = "#"+selected_user+" .startup_count";
                var new_selected_user_license = "#"+selected_user+" .license_count";
                
                var child_startup = $(new_selected_user).text();
                var child_license = $(new_selected_user_license).text();

                var child_startup_count = parseInt(child_startup,10);
                var child_license_count = parseInt(child_license,10);

                if(assign_num=="") $('#startup_num').val(0);
                if(assign_license_num=="") $('#license_num').val(0);
                @if(Auth::user()->role=="Admin")
                    if($('#startup_num').val()==0 && $('#license_num').val()==0) e.preventDefault();
                @else
                    if($('#startup_num').val()==0) e.preventDefault();
                @endif
                console.log(data['startup']);   
                console.log(assign_num);
                if(is<0){                    
                    alert("{{__('app.user_validation')}}");
                    e.preventDefault();
                }
                if(count['license']<assign_license_num){
                    alert("{{__('app.not_enough_license_code1')}}");
                    e.preventDefault();
                }
                if(count['startup']<assign_num)
                {
                    alert("{{__('app.not_enough_startup_codes1')}}");
                    e.preventDefault();
                }
                if(assign_license_num<0 && -1*assign_license_num>child_license_count){
                    alert("{{__('app.not_enough_license_code2')}}");
                    e.preventDefault();
                }
                if(assign_num<0 && -1*assign_num>child_startup_count){
                    alert("{{__('app.not_enough_startup_codes2')}}");
                    e.preventDefault();
                }

            });
            
            $('#startup-table').on("click",".table-body tr",function(){
                var user_name = $(this).attr('id');
                @if(Auth::user()->role=="Admin")
                    $("#license_select_user").val(user_name);
                @endif  
                $('#startup_select_user').val(user_name);
                $('.table-body').find('td').removeClass('bg-success');
                $(this).find('td').addClass('bg-success');
            });
        });
    </script>
@endpush