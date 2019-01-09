@extends('layouts.layout')

@push('header-style')
<style>
    h3{
        color:#14addb;
    }
    #license_form h5{
        color:#14addb;
    }
    #license_form {
        padding-top:10px;
    }
</style>
@endpush

@section('content')
<div class="sb2-2">
    <div class="sb2-2-2">
        <ul>
            <li>
                <a href="">
                    <i class="fa fa-home" aria-hidden="true"></i> {{__('app.code_management')}}</a>
            </li>
            <li class="active-bre">
                <a href=""> {{__('app.generate_license_code')}} </a>    
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.create_license_code')}}</h4> 
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
            <ul id="dr-list" class="dropdown-content">
                <li><a href="{{URL::to('/code/showAllCodes')}}"><i class="material-icons">subject</i>{{__('app.show_all_codes')}}</a> </li>
                <li><a href="{{URL::to('/code/showGenerateStartupForm')}}"><i class="material-icons">subject</i>{{__('app.generate_startup_code')}}</a> </li>
                @if(Auth::user()->role!="Client")
                <li><a href="{{URL::to('/code/showAssignCodeForm')}}"><i class="material-icons">subject</i>{{__('app.assign_codes')}}</a> </li>
                @endif
            </ul>       
            <!-- Dropdown Structure -->
            <div class="split-row">
                <div class="col-md-12">
                    <div class="box-inn-sp ad-inn-page">
                        <div class="tab-inn ad-tab-inn">
                            @if(Auth::user()->role=="Admin")
                            <h3 style="padding-top:10px" class="text-center"> {{__('app.license_codes_available')}}:--- </h3> 
                            @else
                            <h3 id="license_code_text" style="padding-top:10px" class="text-center"> {{__('app.license_codes_available')}}:{{Auth::user()->license}} </h3> 
                            @endif
                            
                            <div class="hom-cre-acc-left hom-cre-acc-right">
                                <div class="">        
                                    <!-- <form method="post" action="{{URL::to('/code/registerLicenseCode')}}"> -->
                                        <form>
                                        @csrf
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="version_id" name="version_id"  type="text" class="validate" value="{{$default_version_id}}">
                                                <label for="version_id">{{__('app.version_id')}}</label>
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="select_board" name="mac_address" type="text" class="form-control" value="{{$default_mac}}">
                                                @if(!empty($errors->has('mac_address')))
                                                    <span class="error">
                                                        {{$errors->first('mac_address')}}
                                                    </span>
                                                @endif   
                                                <label for="select_board">{{__('app.mac_address')}}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="request_key" name="request_key" type="text" class="validate" value="{{$default_request_key}}">
                                                @if(!empty($errors->has('request_key')))
                                                    <span class="error">
                                                        {{$errors->first('request_key')}}
                                                    </span>
                                                @endif   
                                                <label for="request_key">{{__('app.request_key')}}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="note" name="note" value="{{ old('note')}}" type="text" class="validate">
                                                @if(!empty($errors->has('note')))
                                                    <span class="error">
                                                        {{$errors->first('note')}}
                                                    </span>
                                                @endif   
                                                <label for="note">{{__('app.note')}}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12"> 
                                                <button id="create_activation_code" class="waves-effect waves-light btn-large full-btn" value="Create User">{{__('app.create_license_code')}} </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div  id="license_form" class="text-center">
                                                <h5 id="license_code_form"> {{__('app.generated_license_code')}}: </h5>
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
        jQuery(function($){
            var data = {};
            var boards = []
            var current_license = {{$current_license}};
            @foreach($boards as $board)
                data["{{$board['mac_address']}}"]=null;
                boards.push("{{$board['mac_address']}}");
            @endforeach
            
            $("#select_board").autocomplete({
                data:data,
                limit: 8, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                    // Callback function when value is autcompleted.
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });
            $('#create_activation_code').click(function(e){
                var version_id = $('#version_id').val();
                var request_key = $('#request_key').val();
                var validation1 = version_id.match("^[0-9a-fA-F]{8}$");
                var validation2 = request_key.match("^[0-9a-fA-F]{14}$");
                var selected_board = $('#select_board').val();
                var is = jQuery.inArray( selected_board, boards);
                var mac_address = $('#select_board').val();
                var note = $('#note').val();
                
                if(is<0){                    
                    alert("No board such mac address");
                }
                
                if(current_license == 0){
                    alert('You have no license code, ask license code to your parent user.');
                }
                
                if(validation1==null){
                    alert("Version id should be 8 digit hex.");
                }

                if(validation2==null){
                    alert("Request key should be 14 digit hex.");
                }
                if(is>=0 && current_license != 0  && validation1!=null && validation2!=null){

                    $.ajax({
                        url:baseUrl+'/code/registerLicenseCode',
                        type:'post',
                        data:{
                            mac_address:mac_address,
                            version_id:version_id,
                            request_key:request_key,
                            note:note,
                        },
                        success:function(response){
                            $('#license_code_form').text("{{__('app.generated_license_code')}}:"+response['generated_license_code']);
                            current_license = response['current_license_num'];
                            $('#license_code_text').html("{{__('app.license_codes_available')}}:"+current_license);
                            $('#version_id').val("");   
                            $('#select_board').val("");
                            $('#request_key').val("");
                            $('#note').val("");
                        }
                    });
                }
            });
        });
    </script>
@endpush