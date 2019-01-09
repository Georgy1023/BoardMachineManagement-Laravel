@extends('layouts.layout')

@push('header-style')
@endpush

@section('content')
<div class="sb2-2">
    <div class="sb2-2-2">
        <ul>
            <li>
                <a >
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.users')}}</a>
            </li>
            <li class="active-bre">
                <a > {{__('app.add_new_user')}}</a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>Add New 
                @if($addRole=="Admin") {{__('app.admin')}}
                @elseif($addRole=="Master") {{__('app.master')}}
                @elseif($addRole=="Customer") {{__('app.customer')}}
                @elseif($addRole=="Client") {{__('app.client')}}
                @endif
            </h4> 
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
            <ul id="dr-list" class="dropdown-content">
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
                                    <form method="post" action="{{URL::to('/user/registerUser')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="user_name" name="user_name" value="{{ old('user_name')}}" id="user_name" type="text" class="validate">
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
                                                <input id="password" name="password" type="text" class="validate">
                                                @if(!empty($errors->has('password')))
                                                    <span class="error">
                                                        {{$errors->first('password')}}
                                                    </span>
                                                @endif
                                                <label for="email">{{__('app.password')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="user_real_name" name="user_real_name" type="text" class="validate">
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
                                                <input id="phone" name="phone"value="{{ old('phone')}}" type="text" class="validate">
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
                                                <input id="email" name="email" value="{{ old('email')}}"  type="email" class="validate">
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
                                                <input id="note" name="note" id="list_addr" type="text" class="validate">
                                                <label for="list_addr">{{__('app.note')}}</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div id="create_user" class="input-field col s12"> 
                                                <button type="submit" class="waves-effect waves-light btn-large full-btn" value="Create User"> {{__('app.create_user')}}</button>
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
    <script src="{{URL::to('js/user.js')}}"></script>
@endpush