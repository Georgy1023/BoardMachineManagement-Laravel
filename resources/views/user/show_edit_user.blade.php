@extends('layouts.layout')

@push('header-style')
 
@endpush

@section('content')
    <!--== BODY INNER CONTAINER ==-->
  
<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li>
                <a href="{{URL::to('user/showAllUser')}}">
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.users')}}</a>
            </li>
            <li class="active-bre">
                <a > {{__('app.my_profile')}}</a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.change_password_for')}} {{$user->user_name}}</h4>
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
                            <div class="hom-cre-acc-left hom-cre-acc-right">
                                <div class="">        
                                    <form method="post" action="{{URL::to('/user/updateProfile')}}">
                                        @csrf
                                        <input type="hidden" value="{{$user->id}}" name="user_id">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input disabled id="user_name" name="user_name" value="@if( old('user_name') ) {{old('user_name')}} @else {{$user->user_name}} @endif"  id="user_name" type="text" class="validate">                                                    
                                                @if(!empty($errors->has('user_name')))
                                                    <span class="error">
                                                        {{$errors->first('user_name')}}
                                                    </span>
                                                @endif
                                                <label for="user_name">{{__('app.login')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="password" name="password" value="@if(old('password')) {{old('password')}} @else {{$user->origin_password}} @endif" type="text" class="validate">  
                                                @if(!empty($errors->has('password')))
                                                    <span class="error">
                                                        {{$errors->first('password')}}
                                                    </span>
                                                @endif                                             
                                                <label for="password">{{__('app.password')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input disabled id="user_real_name" name="user_real_name" value="@if(old('user_real_name')) {{old('user_real_name')}} @else {{$user->user_real_name}} @endif" type="text" class="validate">  
                                                @if(!empty($errors->has('user_real_name')))
                                                    <span class="error">
                                                        {{$errors->first('user_real_name')}}
                                                    </span>
                                                @endif                                             
                                                <label for="user_real_name">{{__('app.name')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input disabled id="phone" name="phone" value="@if(old('phone')) {{old('phone')}} @else {{$user->phone}} @endif" type="text" class="validate">
                                                @if(!empty($errors->has('phone')))
                                                    <span class="error">
                                                        {{$errors->first('phone')}}
                                                    </span>
                                                @endif
                                                <label for="phone">{{__('app.phone')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input disabled id="email" name="email" value="@if(old('email')) {{old('email')}} @else {{$user->email}} @endif"  type="email" class="validate">
                                                @if(!empty($errors->has('email')))
                                                    <span class="error">
                                                        {{$errors->first('email')}}
                                                    </span>
                                                @endif
                                                <label for="email">{{__('app.email')}}</label>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input disabled id="note" name="note" id="list_addr" value="{{$user->note}}" type="text" class="validate">
                                                <label for="list_addr">{{__('app.note')}}</label>
                                            </div>
                                        </div>                                        
                                        <div class="row">
                                            <div id="create_user" class="input-field col s12"> 
                                                <button type="submit" class="waves-effect waves-light btn-large full-btn" value="Create User"> {{__('app.update_user')}} </button>
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