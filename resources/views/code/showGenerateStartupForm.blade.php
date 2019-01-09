@extends('layouts.layout')

@push('header-style')
<style>
    h3{
        color:#14addb;
    }
    #startup_form h5{
        color:#14addb;
    }
    #startup_form {
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
                <a href=""> {{__('app.generate_startup_code')}} </a>    
            </li>
        </ul>
    </div>
    <div class="tz-2 tz-2-admin">
        <div class="tz-2-com tz-2-main">
            <h4>{{__('app.create_activation_code')}}</h4> 
            <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
            <ul id="dr-list" class="dropdown-content">
                <li><a href="{{URL::to('/code/showAllCodes')}}"><i class="material-icons">subject</i>{{__('app.show_all_codes')}}</a> </li>
                @if(Auth::user()->role=="Admin" || Auth::user()->role=="Master")
                <li><a href="{{URL::to('/code/showGenerateLicenseForm')}}"><i class="material-icons">subject</i>{{__('app.generate_license_code')}}</a> </li>
                @endif
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
                            <h3 style="padding-top:10px;" class="text-center"> {{__('app.startup_codes_available')}}:--- </h3>
                            @else
                                @if(Auth::user()->startup==0 && Auth::user()->role=="Client")
                                <h3 style="padding-top:10px;" class="text-center alert alert-danger">{{__('app.startup_code_count_validation')}}</h4>
                                @else
                                <h3 id='startup_code_text' style="padding-top:10px;" class="text-center"> {{__('app.startup_codes_available')}}:{{Auth::user()->startup}} </h3>
                                @endif
                            @endif
 
                            <div class="hom-cre-acc-left hom-cre-acc-right">
                                <div class="">        
                                    <form method="post">
                                        @csrf
                                        <!-- <div class="row">
                                            <div class="input-field col s12">
                                                <input id="select_board" name="mac_address" type="text" class="form-control">
                                                <label for="select_board">Mac Address</label>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="startup_code" name="startup_code" type="text" class="form-control" value="@if(isset($default_startup)){{$default_startup}}@endif">
                                                <label for="startup_code">{{__('app.startup_code')}}</label>
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
                                                <button id="create_license_code" class="waves-effect waves-light btn-large full-btn" value="Create User"> {{__('app.create_startup_code')}} </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div  id="startup_form" class="text-center">
                                                <h5 id="startup_code_form"> {{__('app.generated_startup_code')}}: </h5>
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
            var current_startup = {{$current_startup}};
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
            $('#create_license_code').click(function(e){
                var startup_code = $('#startup_code').val();
                var validation1 = startup_code.match("^[0-9a-fA-F]{26}$");
                var mac_address = "";
                if(validation1 != null){
                    mac_address = startup_code.substr(0,12);
                      e.preventDefault();
                    var is = jQuery.inArray(mac_address, boards);
                 }

                var note = $('#note').val();

                if(validation1==null){
                    alert("{{__('app.startup_code_format_validation')}}");
                }

                if(is<0){                    
                    alert("{{__('app.board_validation')}}"+mac_address);
                    e.preventDefault();
                }

                if(current_startup == 0){
                    alert("{{__('app.startup_code_to_child_validation')}}");
                    e.preventDefault();
                }
                
              
                if(is>=0 && current_startup!=0){

                    $.ajax({
                        url:baseUrl+'/code/registerStartupCode',
                        type:'post',
                        data:{
                            mac_address:mac_address,
                            note:note,
                            startup_code:startup_code
                        },
                        success:function(response){
                            $('#startup_code_form').text("{{__('app.generated_startup_code')}}:"+response['generated_activation_code']);
                            current_startup = response['startup_count'];
                            $('#startup_code_text').html("{{__('app.startup_codes_available')}}:"+current_startup);
                            $('#startup_code').val("");
                            $('#note').val("");
                            $('#start_code_form').css('color','red');
                        }
                    });
                }
            });
            @if(Auth::user()->startup==0 && Auth::user()->role=="Client")
                alert("{{__('app.no_startup_code')}}");
            @endif
        });
    </script>
@endpush