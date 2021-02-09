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
								message: 'Email is required'
							},
							emailAddress: {
								message: 'Invalid email address'
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

			validation.validate().then(function (status) {
				console.log(status);
				if (status == 'Valid') {
					$.ajax({
						url: login_url,
						type: 'POST',
						data: '_token=' + cToken + '&' + values,
						success: function (res) {
							console.log('success');
							var obj = $.JSON.parse(res);

							swal.fire({
								text: 'All is cool! Now you submit this form',
								icon: 'success',
								buttonsStyling: false,
								confirmButtonText: 'Ok, got it!',
								customClass: {
									confirmButton: 'btn font-weight-bold btn-light-primary'
								}
							}).then(function() {
								KTUtil.scrollTop();
							});

							console.log(obj);
							// location.reload();
						},
						error: function (res) {
							console.log('error');
							var obj = $.JSON.parse(res);
							console.log(obj);
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
	}

	_handleSignInForm();

})(jQuery);

