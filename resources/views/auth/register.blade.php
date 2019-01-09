@extends('layouts.page')

@section('content')
        <section class="tz-register">
			<div class="log-in-pop">
				<div class="log-in-pop-left">
					<h1>Hello... </h1>
					<p>Don't have an account? Create your account. It's take less then a minutes</p>
					<h4>Login with social media</h4>
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i> Facebook</a>
						</li>
						<li><a href="#"><i class="fa fa-google"></i> Google+</a>
						</li>
					</ul>
				</div>
				<div class="log-in-pop-right">
					<a href="#" class="pop-close" data-dismiss="modal"><img src="images/cancel.png" alt="" />
					</a>
					<h4>Create an Account</h4>
					<p>Don't have an account? Create your account. It's take less then a minutes</p>
					<form class="s12" method="POST" action="{{ route('register') }}">
                        @csrf
						<div>
							<div class="input-field s12">
								<input type="text" data-ng-model="name1" class="validate" name="name" value="{{ old('name') }}" required autofocus>
								<label>User name</label>
							</div>
						</div>
						<div>
							<div class="input-field s12">
								<input type="email" class="validate" name="email" value="{{ old('email') }}" required>
								<label>Email id</label>
							</div>
						</div>
						<div>
							<div class="input-field s12">
								<input type="password" class="validate" name="password" required>
								<label>Password</label>
							</div>
						</div>
						<div>
							<div class="input-field s12">
								<input type="password" class="validate" name="password_confirmation" required>
								<label>Confirm password</label>
							</div>
						</div>
						<div>
							<div class="input-field s4">
								<input type="submit" value="Register" class="waves-effect waves-light log-in-btn"> </div>
						</div>
						<div>
							<div class="input-field s12"> <a href="login.html">Are you a already member ? Login</a> </div>
						</div>
					</form>
				</div>
			</div>
	</section>
@endsection