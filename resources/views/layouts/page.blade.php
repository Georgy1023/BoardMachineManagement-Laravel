<!DOCTYPE html>
<html lang="en">

<head>
	<title>Board Renting Management System</title>
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
	<link href="{{URL::to('/assets')}}/css/style.css" rel="stylesheet">
	<link href="{{URL::to('/assets')}}/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	<link href="{{URL::to('/assets')}}/css/responsive.css" rel="stylesheet">
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
    @yield('content')

    <script src="{{URL::to('/assets')}}/js/jquery.min.js"></script>
	<script src="{{URL::to('/assets')}}/js/angular.min.js"></script>
	<script src="{{URL::to('/assets')}}/js/bootstrap.js" type="text/javascript"></script>
	<script src="{{URL::to('/assets')}}/js/materialize.min.js" type="text/javascript"></script>
	<script src="{{URL::to('/assets')}}/js/custom.js"></script>
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var baseUrl = "{{URL::to('/')}}";
		var proxyUrl = "https://cors-anywhere.herokuapp.com/";
	</script>
    @stack('footer-script')
</body>

</html>

