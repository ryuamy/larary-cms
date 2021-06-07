(function ($) {
	'use strict';

	var baseUrl = $('body').data('baseurl');
	var cToken = $('body').data('ctoken');

	function _handleSignInForm() {
		var validation;

		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_signin_form'),
			{
				fields: {
					username: {
						validators: {
							notEmpty: {
								message: 'Username is required'
							},
							regexp: {
								regexp: /^[a-z0-9]+$/i,
								message: 'Username can consist of alphabetical'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'Password is required'
							},
							regexp: {
								regexp: /^[\w\-\s]+$/,
								message: 'Password can consist of alphabetical, numeric and spaces only'
							}
						}
					},
					captcha: {
						validators: {
							notEmpty: {
								message: 'Please enter captcha'
							},
							stringLength: {
								min: 5,
								max: 5,
								message: 'Captcha must be have 5 characters'
							},
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					submitButton: new FormValidation.plugins.SubmitButton(),
					//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		$('#kt_login_signin_submit').on('click', function (e) {
			e.preventDefault();

			var values = $('#kt_login_signin_form').serialize();
			var login_url = baseUrl + 'ajax/login';

			var bx_alert_message_login = `<div class="alert alert-custom alert-danger mb-5 show fade" role="alert">
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
						</div>`;

			validation.validate().then(function (status) {
				console.log(status);
				if (status == 'Valid') {
					$.ajax({
						url: login_url,
						type: 'POST',
						data: '_token=' + cToken + '&' + values,
						success: function (response, textStatus, request) {
							// console.log(response);
							// console.log(textStatus);
							// console.log(request);
							swal.fire({
								text: 'Success login',
								icon: 'success',
								buttonsStyling: false,
								confirmButtonText: 'Go To Dashboard',
								customClass: {
									confirmButton: 'btn font-weight-bold btn-light-primary'
								}
							}).then(function() {
								KTUtil.scrollTop();
								if (request.status == 200) {
									window.location.replace(response.datas.redirect);
								} else {
									$('#bx_alert_message_login').html(bx_alert_message_login);
									$('#alert_message_login').html(response.responseJSON.message);
								}
							});
						},
						error: function (response, textStatus, request) {
							// console.log(response);
							// console.log(textStatus);
							// console.log(request);
							$('#bx_alert_message_login').html(bx_alert_message_login);
							$('#alert_message_login').html(response.responseJSON.message);
						}
					});
				} else {
					swal.fire({
						text: 'Sorry, looks like there are some errors detected, please try again.',
						icon: 'error',
						buttonsStyling: false,
						confirmButtonText: 'Ok, got it!',
						customClass: {
							confirmButton: 'btn font-weight-bold btn-light-primary'
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});

		$('#reload').click(function () {
			$('.captcha span').html('loading new captcha...');
			$.ajax({
				type: 'GET',
				url: baseUrl + 'ajax/reload-captcha',
				success: function (data) {
					$('.captcha span').html(data.captcha);
				}
			});
		});
	}

	_handleSignInForm();

})(jQuery);

