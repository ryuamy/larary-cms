(function ($) {
	'use strict';

	var baseUrl = $('body').data('baseurl');
	var cToken = $('body').data('ctoken');

	function _handleSignInForm() {
		var validation;

		validation = FormValidation.formValidation(
			KTUtil.getById('user_login_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Email is required'
							},
							regexp: {
								regexp: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
								message: 'Email format is invalid'
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
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		$('#user_login').on('click', function (e) {
			e.preventDefault();

			var values = $('#user_login_form').serialize();
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
                            _reloadCaptcha();
							swal.fire({
								html: 'Success login.<br />Please wait, you will be redirected to home.',
								icon: 'success',
								showConfirmButton: false,
								showCancelButton: false,
							});
							if (request.status == 200) {
								setTimeout(function () {
									window.location.replace(response.datas.redirect);
								}, 7500);
							} else {
								$('#bx_alert_message_login').html(bx_alert_message_login);
								$('#alert_message_login').html(response.responseJSON.message);
							}
						},
						error: function (response, textStatus, request) {
                            _reloadCaptcha();
							$('#bx_alert_message_login').html(bx_alert_message_login);
							$('#alert_message_login').html(response.responseJSON.message);
						}
					});
				} else {
                    _reloadCaptcha();
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
	}

    function _reloadCaptcha() {
        $('.captcha span').html('loading new captcha...');
        $.ajax({
            type: 'GET',
            url: baseUrl + 'ajax/reload-captcha',
            success: function (data) {
                $('.captcha span').html(data.captcha);
            }
        });
    }

    $('#reload').click(function () {
        _reloadCaptcha();
    });

	_handleSignInForm();

})(jQuery);

