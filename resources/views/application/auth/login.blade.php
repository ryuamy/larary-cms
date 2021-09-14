
<!DOCTYPE html>

<html lang="en">
	<head>
		<base href="{{ url('/') }}" />
		<meta charset="utf-8" />
		<title>{{ $meta["title"] }}</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

		<link href="{{ asset('/css/global/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('/css/global/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('/css/global/style.bundle.css') }}" rel="stylesheet" type="text/css" />

		<link rel="shortcut icon" href="{{ asset('/media/favicon.ico') }}" />

	</head>

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"
		data-baseurl="{{ url('/').'/' }}" data-ctoken="{{ csrf_token() }}"
	>

		<div class="d-flex flex-column flex-root">

			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
					style="background-image: url('{{ asset('/media/admin/layout/bg-login.jpg') }}');"
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

		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>

		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>

		<script src="{{ asset('/js/global/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/scripts.bundle.js') }}"></script>

		<script src="{{ asset('/js/application/login.js') }}"></script>

		<?php /** reCaptcha */ ?>
		<?php /*{!! NoCaptcha::renderJs() !!} */ ?>

	</body>
</html>
