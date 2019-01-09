<!DOCTYPE html>
<html lang="en">

<head>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="images/fav.ico" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<!-- FONTAWESOME ICONS -->
	<link rel="stylesheet" href="{{URL::to('/assets')}}/css/font-awesome.min.css">
	<!-- ALL CSS FILES -->
    <link href="{{URL::to('/assets')}}/css/materialize.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/datatable.min.css" rel="stylesheet">
	<link href="{{URL::to('/assets')}}/css/style.css" rel="stylesheet">
	<link href="{{URL::to('/assets')}}/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
    <link href="{{URL::to('/assets')}}/css/responsive.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/common.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/css/msdropdown/dd.css" />
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/css/msdropdown/flags.css" />
    <style>
        .borderRadiusTp .divider{
            display:none;
        }
        .borderRadiusTp .arrow{
            display:none;
        }
    </style>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
    @stack('header-style')
    
</head>

<body data-ng-app="">
    <div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
    <div class="container-fluid sb1">
        <div class="row">
            <!--== LOGO ==-->
            <div class="col-md-2 col-sm-3 col-xs-6 sb1-1"> <a href="#" class="btn-close-menu"><i class="fa fa-times" aria-hidden="true"></i></a> <a href="#" class="atab-menu"><i class="fa fa-bars tab-menu" aria-hidden="true"></i></a>
                <a href="{{URL::to('/dashboard')}}" class="logo"><img src="{{URL::to('assets')}}/images/logo1.png" alt=""> </a>
            </div>
            <!--== MY ACCCOUNT ==-->
            <div class="col-md-8 col-sm-5 col-xs-2 sb1-1"> </div>
            <div class="col-md-2 col-sm-3 col-xs-4 sb1-1" style="padding-top:20px">
                <select name="countries" id="countries" style="width:300px;">

                    <option @if(app()->getLocale('lang')=='en') selected @endif value='en' data-image="{{URL::to('/')}}/images/msdropdown/icons/blank.gif" data-imagecss="flag us" data-title="United States">English</option>
                    <option @if(app()->getLocale('lang')=='de') selected @endif value='de' data-image="{{URL::to('/')}}/images/msdropdown/icons/blank.gif" data-imagecss="flag de" data-title="Germany">Deutsche</option>
                    <option @if(app()->getLocale('lang')=='es') selected @endif value='es' data-image="{{URL::to('/')}}/images/msdropdown/icons/blank.gif" data-imagecss="flag es" data-title="Spain">Español</option>
                    <option @if(app()->getLocale('lang')=='ro') selected @endif value='ro' data-image="{{URL::to('/')}}/images/msdropdown/icons/blank.gif" data-imagecss="flag ro" data-title="Romania">Română</option>
                </select>   
            </div>
        </div>
	</div>
    <div class="container-fluid sb2">
        <div class='row'>
            <div class="sb2-1">
                    <!--== USER INFO ==-->
                    <div class="sb2-12">
                        <ul>
                            <li><img src="{{URL::to('assets')}}/images/avatar.png" alt=""> </li>
                            <li>
                                <h5>
                                @if($role=="Admin") {{__('app.admin')}}
                                @elseif($role=="Master") {{__('app.master')}}
                                @elseif($role=="Customer") {{__('app.customer')}}
                                @elseif($role=="Client") {{__('app.client')}}
                                @endif
                                    <span> {{Auth::user()->user_name}}
                                    </span>
                                </h5> 
                            </li>
                            <li></li>
                        </ul>
                    </div>
                    @php
                        $currentRootName = Route::currentRouteName();
                    @endphp
                    <!--== LEFT MENU ==-->  
                    <div class="sb2-13">
                        
                        <ul class="collapsible" data-collapsible="accordion">
                            @if(Auth::user()->role != "Client") 
                                <li><a href="{{URL::to('dashboard')}}" class="menu-active"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('app.dashboard')}}</a> </li>                            
                            @endif
                            <li class="@if($currentRootName == 'show_add_user' || $currentRootName == 'show_all_user' || $currentRootName == 'show_son_list' || $currentRootName == 'show_password_form' || $currentRootName == 'update_profile') active @endif">
                                <a href="javascript:void(0)" class="collapsible-header @if($currentRootName == 'show_add_user' || $currentRootName == 'show_all_user' || $currentRootName == 'show_son_list' || $currentRootName == 'show_password_form' || $currentRootName == 'update_profile' ) active @endif">
                                <i class="fa fa-user" aria-hidden="true"></i> {{__('app.users')}}</a>
                                <div class="collapsible-body left-sub-menu">
                                    <ul>
                                        @if(Auth::user()->role != "Client")
                                        <li class="@if($currentRootName == 'show_all_user') active @endif">
                                            <a href="{{URL::to('user/showAllUser')}}">{{__('app.show_child_users')}}</a> 
                                        </li>
                                        <li class="@if($currentRootName == 'show_add_user') active @endif">
                                            <a href="{{URL::to('user/showAddUser')}}">{{__('app.add_new_user')}}</a> 
                                        </li>
                                        <li class="@if($currentRootName == 'show_son_list') active @endif">
                                            <a href="{{URL::to('user/showSonList')}}">{{__('app.change_password')}}</a>
                                        </li>
                                        @endif
                                        <li class="@if($currentRootName == 'update_profile') active @endif">
                                            <a href="{{URL::to('user/showProfile')}}"> {{__('app.my_profile')}} </a>
                                        </li>
                                    </ul>
                                </div>
						    </li>
                            <li class="@if($currentRootName =='register_board' || $currentRootName == 'show_all_boards' || $currentRootName == 'show_assign_board' || $currentRootName=='show_return_board') active @endif">
                                <a href="javascript:void(0)" class="collapsible-header @if($currentRootName =='show_register_board' || $currentRootName == 'show_all_boards' || $currentRootName == 'show_assign_board' || $currentRootName=='show_return_board') active @endif">
                                    <i class="fa fa-building" aria-hidden="true"></i> {{__('app.boards')}}
                                </a> 
                                <div class="collapsible-body left-sub-menu">
                                    <ul>
                                        @if(Auth::user()->role == "Admin")
                                            <li class="@if($currentRootName == 'create_board') active @endif">
                                                <a href="{{URL::to('board/showRegisterBoard')}}">{{__('app.register_board')}}</a> 
                                            </li>
                                        @endif
                                        @if(Auth::user()->role == "Admin" || Auth::user()->role == "Master")
                                            <li class="@if($currentRootName == 'show_return_board') active @endif">
                                                <a href="{{URL::to('board/showReturnBoard')}}">{{__('app.return_board')}}</a> 
                                            </li>
                                        @endif
                                        <li class="@if($currentRootName == 'show_boards') active @endif">
                                            <a href="{{URL::to('board/showAllBoards')}}">{{__('app.show_all_boards')}}</a> 
                                        </li>
                                        @if(Auth::user()->role != "Client")
                                        <li class="@if($currentRootName == 'show_assign_board') active @endif">
                                            <a href="{{URL::to('board/showAssignBoard')}}">{{__('app.assign_boards')}}</a> 
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            <li class="@if($currentRootName =='show_generate_license_form' || $currentRootName == 'show_generate_startup_form' || $currentRootName == 'show_assign_code_form' || $currentRootName == 'show_all_codes') active @endif">
                                <a href="javascript:void(0)" class="collapsible-header @if($currentRootName =='show_generate_license_form' || $currentRootName == 'show_generate_startup_form' || $currentRootName == 'show_assign_code_form' || $currentRootName == 'show_all_codes') active @endif">
                                    <i class="fa fa-key" aria-hidden="true"></i> {{__('app.code_management')}}
                                </a> 
                                <div class="collapsible-body left-sub-menu">
                                    <ul>
                                        @if(Auth::user()->role == "Admin" || Auth::user()->role == "Master")
                                            <li class="@if($currentRootName == 'show_generate_license_form') active @endif">
                                                <a href="{{URL::to('code/showGenerateLicenseForm')}}">{{__('app.generate_license_code')}}</a> 
                                            </li>
                                        @endif
                                        <li class="@if($currentRootName == 'show_generate_startup_form') active @endif">
                                            <a href="{{URL::to('code/showGenerateStartupForm')}}">{{__('app.generate_startup_code')}}</a> 
                                        </li>
                                        @if(Auth::user()->role != "Client")
                                            <li class="@if($currentRootName == 'show_assign_code_form') active @endif">
                                                <a href="{{URL::to('code/showAssignCodeForm')}}">{{__('app.assign_codes')}}</a> 
                                            </li>      
                                        @endif
                                        <li class="@if($currentRootName == 'show_all_codes') active @endif">
                                            <a href="{{URL::to('code/showAllCodes')}}">{{__('app.show_all_codes')}}</a> 
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="{{URL::to('/logout')}}" class="menu-active"><i class="fa fa-sign-in" aria-hidden="true"></i> logout</a> </li>
                         </ul>
                    </div>
            </div>
            <form method="get" action="{{URL::to('/changeLanguage')}}" id="lang_form">
                <input hidden id="language" name="language" val="en">
            </form>
            @yield('content')
        </div>
    </div>





    <script src="{{URL::to('/assets')}}/js/jquery.min.js"></script>
    <script src="{{URL::to('/js')}}/datatable.min.js"></script> 
	<script src="{{URL::to('/assets')}}/js/angular.min.js"></script>
	<script src="{{URL::to('/assets')}}/js/bootstrap.js" type="text/javascript"></script>
	<script src="{{URL::to('/assets')}}/js/materialize.min.js" type="text/javascript"></script>
    <script src="{{URL::to('/assets')}}/js/custom.js"></script>	
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{URL::to('/')}}/js/msdropdown/jquery.dd.min.js"></script>

    <script>
        var baseUrl = "{{URL::to('/')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#countries").msDropdown();
        $('#countries').change(function(){
            var val = $(this).val();
            $('#language').val(val);
            val = $('#language').val();
            $('#lang_form').submit();
        });

    </script>
    
    @stack('footer-script')
</body>

</html>

