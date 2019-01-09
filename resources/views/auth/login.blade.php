@extends('layouts.page')

@push('header-style')
	<style>
		html, body{
			height:100%;
		}
		#background_panel {
			background-image:url('images/background.jpg');
		}
	</style>
@endpush
@section('content')

<section class="tz-register" style="height:100%;" id="background_panel">
			<div class="log-in-pop">
				<div class="log-in-pop-left">
					<h1>Hello... <span></span></h1>
					<p>Don't have an account? Create your account. It's take less then a minutes</p>
					<h4>Login with social media</h4>
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i> Facebook</a>
						</li>
						<li><a href="#"><i class="fa fa-google"></i> Google+</a>
						</li>
						<li><a href="#"><i class="fa fa-twitter"></i> Twitter</a>
						</li>
					</ul>
				</div>
				<div class="log-in-pop-right">
					<a href="#" class="pop-close" data-dismiss="modal"><img src="images/cancel.png" alt="" />
					</a>
					<h4>Login</h4>
					<p>Don't have an account? Create your account. It's take less then a minutes</p>
					<form class="s12"  method="POST" action="{{ route('login') }}">
                        @csrf
						<div>
							<div class="input-field s12">
								<input type="text" class="validate"  name="user_name" value="{{ old('user_name') }}" required>
								<label>LoginID</label>	
							</div>
                            @if ($errors->has('user_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
						</div>
						<div>
							<div class="input-field s12">
								<input type="password" class="validate" name="password" required>
								<label>Password</label>
							</div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
						</div>
						<div>
							<div class="input-field s4">
								<input type="submit" value="Login" class="waves-effect waves-light log-in-btn text-center"> </div>
						</div>
					</form>
				</div>
			</div>
	</section>
@endsection