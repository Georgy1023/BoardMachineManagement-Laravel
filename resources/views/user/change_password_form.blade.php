@extends('layouts.layout')

@push('header-style')
<style>
    .password_text{
        padding-left: 20px;
        padding-top: 10px;
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
                <a href="{{URL::to('user/showAllUser')}}">
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.users')}} </a>
            </li>
            <li class="active-bre">
                <a href="#">{{__('app.change_password')}}</a>
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
                                    <form method="post" action="{{URL::to('/user/changePassword')}}/{{$user->id}}">
                                        @csrf  
                                        <!-- <div class="row">
                                            <label class="password_text" for="password"> Old Password </label>
                                            <div class="input-field col s12">
                                                <input id="password" name="old_password" value="@if(old('password')) {{old('password')}} @else {{$user->origin_password}} @endif" type="text" class="validate">  
                                                @if(!empty($errors->has('password')))
                                                    <span class="error">
                                                        {{$errors->first('password')}}
                                                    </span> 
                                                @endif                                             
                                                <label for="email">Old Password</label>
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <label class="password_text" for="new_password">{{__('app.new_password')}}</label>
                                            <div class="input-field col s12">
                                                <input id="new_password" name="new_password" type="password" class="validate">
                                                @if(!empty($errors->has('new_password')))
                                                    <span class="error">
                                                        {{$errors->first('new_password')}}
                                                    </span>
                                                @endif 
                                                <label for="new_password">{{__('app.new_password')}}</label>
                                            </div>
                                        </div>                                        
                                        <div class="row">
                                            <label class="password_text" for="confirm_password"> {{__('app.confirm_password')}} </label>
                                            <div class="input-field col s12">
                                                <input id="confirm_password" name="new_password_confirmation" type="password" class="validate">
                                                @if(!empty($errors->has('confirm_password')))
                                                    <span class="error">
                                                        {{$errors->first('confirm_password')}}
                                                    </span>
                                                @endif 
                                                <label for="confirm_password">{{__('app.confirm_password')}}</label>
                                            </div>
                                        </div>                                        
                                        <div class="row">
                                            <div id="create_user" class="input-field col s12"> 
                                                <button type="submit" class="waves-effect waves-light btn-large full-btn"> {{__('app.change_password')}} </button>
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