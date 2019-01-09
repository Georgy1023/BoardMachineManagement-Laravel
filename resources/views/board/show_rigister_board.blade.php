@extends('layouts.layout')

@push('header-style')
@endpush

@section('content')
<div class="sb2-2">
    <div class="sb2-2-2">
        <ul>
            <li>
                <a href="">
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.boards')}}</a>
            </li>
            <li class="active-bre">
                <a href=""> {{__('app.register_board')}}</a>
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.add_register_board')}}</h4> 
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
            <ul id="dr-list" class="dropdown-content">
                <li><a href="{{URL::to('/board/showAllBoards')}}"><i class="material-icons">subject</i>{{__('app.show_all_boards')}}</a> </li>
                @if(Auth::user()->role!="Clinet")
                <li><a href="{{URL::to('/board/showAssignBoard')}}"><i class="material-icons">subject</i>{{__('app.assign_boards')}}</a> </li>
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
                            <div class="hom-cre-acc-left hom-cre-acc-right">
                                <div class="">        
                                <!-- 'mac_address', 'producer', 'sub_version','created','version_id','activated','wibu_serial','request_key',
        'license_code_requested_num','last_license_code_requested','startup_code_requested_num','last_startup_code_requested',
        'sold_rented_to','note' -->
                                    <form method="post" action="{{URL::to('/board/registerBoard')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="mac_address" name="mac_address"value="{{ old('mac_address')}}" type="text" class="validate">
                                                @if(!empty($errors->has('mac_address')))
                                                    <span class="error">
                                                        {{$errors->first('mac_address')}}
                                                    </span>
                                                @endif   
                                                <label for="mac_address">{{__('app.mac_address')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="producer" name="producer"value="{{ old('producer')}}" type="text" class="validate">
                                                @if(!empty($errors->has('producer')))
                                                    <span class="error">
                                                        {{$errors->first('producer')}}
                                                    </span>
                                                @endif   
                                                <label for="producer">{{__('app.producer')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="select-wrapper">
                                                    <select class="startup_period" name="startup_period">
                                                        <option value="0">OFF</option>
                                                        <option value="30">30 days</option>
                                                        <option value="60">60 days</option>
                                                        <option value="90">90 days</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="input-field col s12">
                                                <input id="sub_version" name="sub_version"value="{{ old('sub_version')}}" type="text" class="validate">
                                                @if(!empty($errors->has('sub_version')))
                                                    <span class="error">
                                                        {{$errors->first('sub_version')}}
                                                    </span>
                                                @endif   
                                                <label for="sub_version">Sub Version</label>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="input-field col s12">
                                                <input id="version_id" name="version_id"value="{{ old('version_id')}}" type="text" class="validate">
                                                @if(!empty($errors->has('version_id')))
                                                    <span class="error">
                                                        {{$errors->first('version_id')}}
                                                    </span>
                                                @endif   
                                                <label for="version_id">Version Id</label>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="wibu_serial" name="wibu_serial" value="{{ old('wibu_serial')}}" type="text" class="validate">
                                                @if(!empty($errors->has('wibu_serial')))
                                                    <span class="error">
                                                        {{$errors->first('wibu_serial')}}
                                                    </span>
                                                @endif   
                                                <label for="wibu_serial">{{__('app.wibu_serial')}}</label>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="input-field col s12">
                                                <input id="request_key" name="request_key"value="{{ old('request_key')}}" type="text" class="validate">
                                                @if(!empty($errors->has('request_key')))
                                                    <span class="error">
                                                        {{$errors->first('request_key')}}
                                                    </span>
                                                @endif   
                                                <label for="request_key">Request Key</label>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="note" name="note"value="{{ old('note')}}" type="text" class="validate">
                                                @if(!empty($errors->has('note')))
                                                    <span class="error">
                                                        {{$errors->first('note')}}
                                                    </span>
                                                @endif   
                                                <label for="note">{{__('app.note')}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="create_user" class="input-field col s12"> 
                                                <button type="submit" class="waves-effect waves-light btn-large full-btn" value="Create User" id="create_board">{{__('app.register_board')}}</button>
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
    <script>
        $(document).ready(function(){
          $("#create_board").click(function(e){
              var mac_address = $("#mac_address").val();
              var result = mac_address.match("^[0-9a-fA-F][0-9a-fA-F]:[0-9a-fA-F][0-9a-fA-F]:[0-9a-fA-F][0-9a-fA-F]:[0-9a-fA-F][0-9a-fA-F]:[0-9a-fA-F][0-9a-fA-F]:[0-9a-fA-F][0-9a-fA-F]$");
              var result1 = mac_address.match("^[0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F][0-9a-fA-F]$");
              if(result || result1){
                  ;
              }
              else{
                alert("{{__('app.mac_address_validate')}}");
                e.preventDefault();
              }
          })
        });
    </script>
@endpush        