@extends('application.layout.app')

@section('content')
	<div class="d-flex flex-column flex-root">

		<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
			<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
				style="background-image: url('{{ asset('/media/global/background/bg-login.jpg') }}');"
			>
				<div class="login-form text-center p-7 position-relative overflow-hidden">

					<div class="login-signin">
						<div class="mb-14">
							<h3>Sign In</h3>
							<div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
						</div>

						<form class="form" id="user_login_form">
							<div id="bx_alert_message_login">
								@if (Session::has('error-message'))
									<div class="alert mb-5 alert-custom alert-danger d-flex show fade" role="alert">
										<div class="alert-text" id="alert_message_login">
											You don't have access
										</div>
										<div class="alert-close">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">
													<i class="ki ki-close"></i>
												</span>
											</button>
										</div>
									</div>
								@endif
							</div>

							<div class="form-group mb-5">
								<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
							</div>

							<div class="form-group mb-5">
								<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" />
							</div>

							<div class="mb-5 d-flex justify-content-center captcha">
								<?php /** reCaptcha */ ?>
								<?php /*{!! app('captcha')->display() !!}*/ ?>
								<?php /*@if ($errors->has('g-recaptcha-response'))
									<span class="help-block">
										<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
									</span>
								@endif*/ ?>

								<span class="bx-image">
									{!! captcha_img() !!}
								</span>
								<button type="button" class="btn btn-danger" class="reload" id="reload">
									&#x21bb;
								</button>
								<div class="form-group mb-0 ml-2">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Enter Captcha" name="captcha" id="captcha" autocomplete="off" />
								</div>
							</div>

							<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
								<div class="checkbox-inline">
									<label class="checkbox m-0 text-muted">
									<input type="checkbox" name="remember" />
									<span></span>Remember me</label>
								</div>
							</div>

							<button id="user_login" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">
								Sign In
							</button>
							<a href="{{ url('login/google') }}" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">
								Sign In With Google
							</a>
						</form>
					</div>

				</div>
			</div>
		</div>

	</div>
@endsection
