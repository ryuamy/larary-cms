<!DOCTYPE html>

<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->

<html lang="en">
	<head>
		<base href="{{ url('/') }}" />

		<title>
            {{ !empty($meta["title"]) ? $meta["title"] : get_site_settings('title') }}
            {{ get_site_settings('separator') }}
            {{ get_site_settings('tagline') }}
        </title>

		<meta charset="utf-8" />
		<meta name="description" content="{{ get_site_settings('description') }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<link rel="canonical" href="{{ url('/') }}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

		<link rel="stylesheet" type="text/css" href="{{ asset('/css/global/metronic_v7.1.2/plugins/global/plugins.bundle.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/global/metronic_v7.1.2/plugins/custom/prismjs/prismjs.bundle.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/global/style.bundle.css') }}" />

		<link rel="stylesheet" type="text/css" href="{{ asset('/css/global/metronic_v7.1.2/themes/layout/header/base/light.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/global/metronic_v7.1.2/themes/layout/header/menu/light.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/global/metronic_v7.1.2/themes/layout/brand/light.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/global/metronic_v7.1.2/themes/layout/aside/light.css') }}" />

        @foreach ($css as $c)
		    <link rel="stylesheet" type="text/css" href="{{ asset('/css/'.$c.'.css') }}" />
        @endforeach

		<link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/admin.css') }}" />

		<link rel="shortcut icon" href="{{ asset('/media/favicon.ico') }}" />
	</head>

	<?php
		$admin_data = Auth::guard('admin')->user();
		$admin_name = explode(' ', $admin_data->name);
		$first_name = $admin_name[0];
		$last_name = isset($admin_name[1]) ? $admin_name[1] : '';
		$cur_uri = current_uri();
	?>

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"
		data-baseurl="{{ url(admin_uri()) }}" data-ctoken="{{ csrf_token() }}"
	>
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<a href="index">
				<img alt="Logo" src="{{ asset('/media/metronic_v7.1.2/media/logos/logo-dark.png') }}" />
			</a>

			<div class="d-flex align-items-center">
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>

				<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>

				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
									fill="#000000"
									fill-rule="nonzero"
									opacity="0.3"
								/>
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
									fill="#000000"
									fill-rule="nonzero"
								/>
							</g>
						</svg>
					</span>
				</button>
			</div>
		</div>

		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-row flex-column-fluid page">
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
					<div class="brand flex-column-auto" id="kt_brand">
						<a href="index" class="brand-logo">
							<img alt="Logo" src="{{ asset('/media/metronic_v7.1.2/media/logos/logo-dark.png') }}" />
						</a>
						<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
											fill="#000000"
											fill-rule="nonzero"
											transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)"
										/>
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
											fill="#000000"
											fill-rule="nonzero"
											opacity="0.3"
											transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)"
										/>
									</g>
								</svg>
							</span>
						</button>
					</div>
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                            <?php /*
                            <?php
                                $datas = [
                                    'admin_modules' => $admin_modules
                                ]
                            ?>
                            {{ view( 'admin.layout.menu', $datas ) }}
                            */ ?>
                            {{ view( 'admin.layout.menu' ) }}
						</div>
					</div>
				</div>

				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<div id="kt_header" class="header header-fixed">
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
								<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
									<ul class="menu-nav">
										<li class="menu-item menu-item-submenu menu-item-here menu-item-open menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											<?php /** TODO : gonna use this as help center shortcut */ ?>
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Help Center</span>
												<i class="menu-arrow"></i>
											</a>
											<div class="menu-submenu menu-submenu-fixed menu-submenu-left" style="width:1000px">
												<div class="menu-subnav">
													<ul class="menu-content">
														<li class="menu-item">
															<h3 class="menu-heading menu-toggle">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">SEO</span>
																<i class="menu-arrow"></i>
															</h3>
															<ul class="menu-inner">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M5.84026576,8 L18.1597342,8 C19.1999115,8 20.0664437,8.79732479 20.1528258,9.83390904 L20.8194924,17.833909 C20.9112219,18.9346631 20.0932459,19.901362 18.9924919,19.9930915 C18.9372479,19.9976952 18.8818364,20 18.8264009,20 L5.1735991,20 C4.0690296,20 3.1735991,19.1045695 3.1735991,18 C3.1735991,17.9445645 3.17590391,17.889153 3.18050758,17.833909 L3.84717425,9.83390904 C3.93355627,8.79732479 4.80008849,8 5.84026576,8 Z M10.5,10 C10.2238576,10 10,10.2238576 10,10.5 L10,11.5 C10,11.7761424 10.2238576,12 10.5,12 L13.5,12 C13.7761424,12 14,11.7761424 14,11.5 L14,10.5 C14,10.2238576 13.7761424,10 13.5,10 L10.5,10 Z" fill="#000000" />
																					<path d="M10,8 L8,8 L8,7 C8,5.34314575 9.34314575,4 11,4 L13,4 C14.6568542,4 16,5.34314575 16,7 L16,8 L14,8 L14,7 C14,6.44771525 13.5522847,6 13,6 L11,6 C10.4477153,6 10,6.44771525 10,7 L10,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																				</g>
																			</svg>
																		</span>
																		<span class="menu-text">Latest Tasks</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<polygon points="0 0 24 0 24 24 0 24" />
																					<path d="M11.2600599,5.81393408 L2,16 L22,16 L12.7399401,5.81393408 C12.3684331,5.40527646 11.7359848,5.37515988 11.3273272,5.7466668 C11.3038503,5.7680094 11.2814025,5.79045722 11.2600599,5.81393408 Z" fill="#000000" opacity="0.3" />
																					<path d="M12.0056789,15.7116802 L20.2805786,6.85290308 C20.6575758,6.44930487 21.2903735,6.42774054 21.6939717,6.8047378 C21.8964274,6.9938498 22.0113578,7.25847607 22.0113578,7.535517 L22.0113578,20 L16.0113578,20 L2,20 L2,7.535517 C2,7.25847607 2.11493033,6.9938498 2.31738608,6.8047378 C2.72098429,6.42774054 3.35378194,6.44930487 3.7307792,6.85290308 L12.0056789,15.7116802 Z" fill="#000000" />
																				</g>
																			</svg>
																		</span>
																		<span class="menu-text">Pending Tasks</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z" fill="#000000" opacity="0.3" />
																					<path d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z" fill="#000000" />
																				</g>
																			</svg>
																		</span>
																		<span class="menu-text">Urgent Tasks</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z" fill="#000000" />
																					<polygon fill="#000000" opacity="0.3" transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747)" points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475" />
																				</g>
																			</svg>
																		</span>
																		<span class="menu-text">Completed Tasks</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M22,17 L22,21 C22,22.1045695 21.1045695,23 20,23 L4,23 C2.8954305,23 2,22.1045695 2,21 L2,17 L6.27924078,17 L6.82339262,18.6324555 C7.09562072,19.4491398 7.8598984,20 8.72075922,20 L15.381966,20 C16.1395101,20 16.8320364,19.5719952 17.1708204,18.8944272 L18.118034,17 L22,17 Z" fill="#000000" />
																					<path d="M2.5625,15 L5.92654389,9.01947752 C6.2807805,8.38972356 6.94714834,8 7.66969497,8 L16.330305,8 C17.0528517,8 17.7192195,8.38972356 18.0734561,9.01947752 L21.4375,15 L18.118034,15 C17.3604899,15 16.6679636,15.4280048 16.3291796,16.1055728 L15.381966,18 L8.72075922,18 L8.17660738,16.3675445 C7.90437928,15.5508602 7.1401016,15 6.27924078,15 L2.5625,15 Z" fill="#000000" opacity="0.3" />
																					<path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508)" />
																				</g>
																			</svg>
																		</span>
																		<span class="menu-text">Failed Tasks</span>
																	</a>
																</li>
															</ul>
														</li>

														<li class="menu-item">
															<h3 class="menu-heading menu-toggle">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Profit Margins</span>
																<i class="menu-arrow"></i>
															</h3>

															<ul class="menu-inner">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Overall Profits</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Gross Profits</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Nett Profits</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Year to Date Reports</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Quarterly Profits</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Monthly Profits</span>
																	</a>
																</li>
															</ul>
														</li>

														<li class="menu-item">
															<h3 class="menu-heading menu-toggle">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Staff Management</span>
																<i class="menu-arrow"></i>
															</h3>

															<ul class="menu-inner">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Top Management</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Project Managers</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Development Staff</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Customer Service</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Sales and Marketing</span>
																	</a>
																</li>

																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Executives</span>
																	</a>
																</li>
															</ul>
														</li>

														<li class="menu-item">
															<h3 class="menu-heading menu-toggle">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Tools</span>
																<i class="menu-arrow"></i>
															</h3>
															<ul class="menu-inner">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="menu-text">Analytical Reports</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="menu-text">Customer CRM</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="menu-text">Operational Growth</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="menu-text">Social Media Presence</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="menu-text">Files and Directories</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<span class="menu-text">Audit &amp; Logs</span>
																	</a>
																</li>
															</ul>
														</li>
													</ul>
												</div>
											</div>
										</li>

										<?php /*
										<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Apps</span>
												<i class="menu-arrow"></i>
											</a>
											<div class="menu-submenu menu-submenu-classic menu-submenu-left">
												<ul class="menu-subnav">
													<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
														<a href="javascript:;" class="menu-link menu-toggle">
															<span class="svg-icon menu-icon">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M3,13.5 L19,12 L3,10.5 L3,3.7732928 C3,3.70255344 3.01501031,3.63261921 3.04403925,3.56811047 C3.15735832,3.3162903 3.45336217,3.20401298 3.70518234,3.31733205 L21.9867539,11.5440392 C22.098181,11.5941815 22.1873901,11.6833905 22.2375323,11.7948177 C22.3508514,12.0466378 22.2385741,12.3426417 21.9867539,12.4559608 L3.70518234,20.6826679 C3.64067359,20.7116969 3.57073936,20.7267072 3.5,20.7267072 C3.22385763,20.7267072 3,20.5028496 3,20.2267072 L3,13.5 Z" fill="#000000" />
																	</g>
																</svg>
															</span>
															<span class="menu-text">Social Presence</span>
															<i class="menu-arrow"></i>
														</a>
														<div class="menu-submenu menu-submenu-classic menu-submenu-right">
															<ul class="menu-subnav">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Reached Users</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">SEO Ranking</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">User Dropout Points</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Market Segments</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Opportunity Growth</span>
																	</a>
																</li>
															</ul>
														</div>
													</li>
													<li class="menu-item" aria-haspopup="true">
														<a href="javascript:;" class="menu-link">
															<span class="svg-icon menu-icon">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M11.575,21.2 C6.175,21.2 2.85,17.4 2.85,12.575 C2.85,6.875 7.375,3.05 12.525,3.05 C17.45,3.05 21.125,6.075 21.125,10.85 C21.125,15.2 18.825,16.925 16.525,16.925 C15.4,16.925 14.475,16.4 14.075,15.65 C13.3,16.4 12.125,16.875 11,16.875 C8.25,16.875 6.85,14.925 6.85,12.575 C6.85,9.55 9.05,7.1 12.275,7.1 C13.2,7.1 13.95,7.35 14.525,7.775 L14.625,7.35 L17,7.35 L15.825,12.85 C15.6,13.95 15.85,14.825 16.925,14.825 C18.25,14.825 19.025,13.725 19.025,10.8 C19.025,6.9 15.95,5.075 12.5,5.075 C8.625,5.075 5.05,7.75 5.05,12.575 C5.05,16.525 7.575,19.1 11.575,19.1 C13.075,19.1 14.625,18.775 15.975,18.075 L16.8,20.1 C15.25,20.8 13.2,21.2 11.575,21.2 Z M11.4,14.525 C12.05,14.525 12.7,14.35 13.225,13.825 L14.025,10.125 C13.575,9.65 12.925,9.425 12.3,9.425 C10.65,9.425 9.45,10.7 9.45,12.375 C9.45,13.675 10.075,14.525 11.4,14.525 Z" fill="#000000" />
																	</g>
																</svg>
															</span>
															<span class="menu-text">Sales &amp; Marketing</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
														<a href="javascript:;" class="menu-link">
															<span class="svg-icon menu-icon">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<polygon fill="#000000" opacity="0.3" points="5 15 3 21.5 9.5 19.5" />
																		<path d="M16,10 L16,9.5 C16,8.11928813 14.8807119,7 13.5,7 C12.1192881,7 11,8.11928813 11,9.5 L11,10 C10.4477153,10 10,10.4477153 10,11 L10,14 C10,14.5522847 10.4477153,15 11,15 L16,15 C16.5522847,15 17,14.5522847 17,14 L17,11 C17,10.4477153 16.5522847,10 16,10 Z M13.5,21 C8.25329488,21 4,16.7467051 4,11.5 C4,6.25329488 8.25329488,2 13.5,2 C18.7467051,2 23,6.25329488 23,11.5 C23,16.7467051 18.7467051,21 13.5,21 Z M13.5,8 L13.5,8 C14.3284271,8 15,8.67157288 15,9.5 L15,10 L12,10 L12,9.5 C12,8.67157288 12.6715729,8 13.5,8 Z" fill="#000000" />
																	</g>
																</svg>
															</span>
															<span class="menu-text">Campaigns</span>
															<span class="menu-label">
																<span class="label label-success label-rounded">3</span>
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										*/ ?>
									</ul>
								</div>
							</div>

							<div class="topbar">
								<div class="dropdown">
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="23 new notification" data-toggle="tooltip" data-placement="bottom" data-theme="dark">
										<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
											<span class="svg-icon svg-icon-xl svg-icon-danger">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
													width="24px" height="24px"
													viewBox="0 0 24 24" version="1.1"
												>
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
															fill="#000000"
															opacity="0.3"
														/>
														<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
															fill="#000000"
														/>
													</g>
												</svg>
											</span>
											<span class="pulse-ring" style="border-color:red;"></span>
										</div>
									</div>

									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<div>
											<div class="d-flex flex-column pt-5 pb-5 bgi-size-cover bgi-no-repeat rounded-top"
												style="background-image: url({{ asset('/media/metronic_v7.1.2/media/misc/bg-1.jpg') }})"
											>
												<h4 class="d-flex flex-center rounded-top">
													<span class="text-white">
														Notifications
													</span>
													<a href="{{ url(admin_uri().'notifications') }}"
														class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2"
													>
														23 new
													</a>
												</h4>
											</div>
											<div class="tab-content">
												<div class="tab-pane active show" id="topbar_notifications_events" role="tabpanel">
													<div class="navi navi-hover scroll my-4" data-scroll="true" data-height="270" data-mobile-height="170">
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-line-chart text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New report has been received</div>
																	<div class="text-muted">23 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-paper-plane text-danger"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Finance report has been generated</div>
																	<div class="text-muted">25 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-user flaticon2-line- text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New order has been received</div>
																	<div class="text-muted">2 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-pin text-primary"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New customer is registered</div>
																	<div class="text-muted">3 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-sms text-danger"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Application has been approved</div>
																	<div class="text-muted">3 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-pie-chart-3 text-warning"></i>
																</div>
																<div class="navinavinavi-text">
																	<div class="font-weight-bold">New file has been uploaded</div>
																	<div class="text-muted">5 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-pie-chart-1 text-info"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New user feedback received</div>
																	<div class="text-muted">8 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-settings text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">System reboot has been successfully completed</div>
																	<div class="text-muted">12 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-safe-shield-protection text-primary"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New order has been placed</div>
																	<div class="text-muted">15 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-notification text-primary"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Company meeting canceled</div>
																	<div class="text-muted">19 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-fax text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New report has been received</div>
																	<div class="text-muted">23 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-download-1 text-danger"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Finance report has been generated</div>
																	<div class="text-muted">25 hrs ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-security text-warning"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New customer comment recieved</div>
																	<div class="text-muted">2 days ago</div>
																</div>
															</div>
														</a>
														<a href="javascript:;" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-analytics-1 text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New customer is registered</div>
																	<div class="text-muted">3 days ago</div>
																</div>
															</div>
														</a>
													</div>
													<?php /*<div class="d-flex flex-center text-center text-muted min-h-200px">All caught up!
														<br />No new notifications.
													</div>*/ ?>
												</div>
											</div>
										</div>
									</div>
								</div>

								<?php /*
								<div class="topbar-item">
									<div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">
										<span class="svg-icon svg-icon-xl svg-icon-primary">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
												width="24px" height="24px"
												viewBox="0 0 24 24" version="1.1"
											>
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
													<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
														fill="#000000"
														opacity="0.3"
													/>
												</g>
											</svg>
										</span>
									</div>
								</div>
								*/ ?>

								<div class="topbar-item">
									<div class="btn btn-icon btn-clean btn-lg mr-1" data-toggle="modal" data-target="#kt_chat_modal">
										<span class="svg-icon svg-icon-xl svg-icon-primary">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
												width="24px" height="24px"
												viewBox="0 0 24 24" version="1.1"
											>
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"
														fill="#000000"
													/>
													<path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"
														fill="#000000"
														opacity="0.3"
													/>
												</g>
											</svg>
										</span>
									</div>
								</div>

								<div class="topbar-item">
									<div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">
										<span class="svg-icon svg-icon-success svg-icon-xl svg-icon-primary">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"/>
												</g>
											</svg>
										</span>
									</div>
								</div>

								<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">
											Hi,
										</span>
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">
											{{ $first_name }}
										</span>
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold">
												{{ substr($first_name, 0, 1) }}
											</span>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1 w-100">
									<div class="d-flex justify-content-between align-items-baseline flex-wrap w-100">
										<div class="d-flex align-items-baseline">
											<h5 class="text-dark font-weight-bold my-1 mr-5">
												{{ $meta['title'] }}
											</h5>

											<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
												@foreach ($breadcrumb as $kB => $b)
													<?php $last_key = count($breadcrumb) - 1;?>
													<li class="breadcrumb-item">
														<a href="{{ url(admin_uri().$b['url']) }}" class="{{ ($kB == $last_key) ? 'text-muted' : '' }}">
															{{ $b['title'] }}
														</a>
													</li>
												@endforeach
											</ul>
										</div>

										<div class="jam-bukutamu">
											<div>
												<span>{{ day_idn(date('w')).', '.date(' d ').month_idn(date('n')).date(' Y') }}</span> -
												<span id="OHours2">00</span><span id="OPoint">:</span><span id="OMin">00</span><span id="OPoint">:</span><span id="OSec">00</span>
												<span id="OAMPM">AM</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<main>
							@yield('content')
						</main>
					</div>

					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2">
									2020&copy;
								</span>
								{{ env('APP_NAME') }} (themes by <a href="http://keenthemes.com/metronic" target="_blank" class="text-dark-75 text-hover-primary">Keenthemes</a>)
							</div>

							<div class="nav nav-dark">
								<a href="{{ admin_uri().'help-center' }}" class="nav-link pl-0 pr-5">
									Help Center
								</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">
					User Profile
					<?php /*
					<small class="text-muted font-size-sm ml-2">
						12 messages
					</small>
					*/ ?>
				</h3>
				<a class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>

			<div class="offcanvas-content pr-5 mr-n5">
				<div class="d-flex align-items-center mt-5">
					<?php /*
					<div class="symbol symbol-100 mr-5">
						<div class="symbol-label"
							style="background-image:url('{{ asset('/media/metronic_v7.1.2/media/users/300_21.jpg') }}')"></div>
						<i class="symbol-badge bg-success"></i>
					</div>
					*/ ?>

					<div class="d-flex flex-column">
						<a href="{{ url(admin_uri().'my-account') }}"
							class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"
						>
							{{ $admin_data->name }}
						</a>
						<?php /*<div class="text-muted mt-1">Admin</div>*/ ?>
						<div class="navi mt-2">
							<a href="mailto:{{ $admin_data->email }}" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
												width="24px" height="24px"
												viewBox="0 0 24 24" version="1.1"
											>
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
												</g>
											</svg>
										</span>
									</span>
									<span class="navi-text text-muted text-hover-primary">
										{{ $admin_data->email }}
									</span>
								</span>
							</a>
							<a href="{{ url(admin_uri().'signout') }}" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">
								Sign Out
							</a>
						</div>
					</div>
				</div>

				<div class="separator separator-dashed mt-8 mb-5"></div>

				<div class="navi navi-spacer-x-0 p-0">
					<a href="{{ url(admin_uri().'my-account') }}" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-success">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
												<circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
											</g>
										</svg>
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">
									My Profile
								</div>
								<div class="text-muted">
									Account settings and more
								</div>
							</div>
						</div>
					</a>

					<a href="{{ url(admin_uri().'messages/inbox') }}" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" fill="#000000" opacity="0.3" />
												<path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000" />
											</g>
										</svg>
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">
									My Messages
								</div>
								<div class="text-muted">
									<span class="label label-light-danger label-inline font-weight-bold">
										12 new
									</span>
									unread messages
								</div>
							</div>
						</div>
					</a>

					<a href="{{ url(admin_uri().'my-account/logs') }}" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-danger">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
											width="24px" height="24px"
											viewBox="0 0 24 24" version="1.1"
										>
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<path d="M4.85714286,1 L11.7364114,1 C12.0910962,1 12.4343066,1.12568431 12.7051108,1.35473959 L17.4686994,5.3839416 C17.8056532,5.66894833 18,6.08787823 18,6.52920201 L18,19.0833333 C18,20.8738751 17.9795521,21 16.1428571,21 L4.85714286,21 C3.02044787,21 3,20.8738751 3,19.0833333 L3,2.91666667 C3,1.12612489 3.02044787,1 4.85714286,1 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z"
													fill="#000000"
													fill-rule="nonzero"
													opacity="0.3"
												/>
												<path d="M6.85714286,3 L14.7364114,3 C15.0910962,3 15.4343066,3.12568431 15.7051108,3.35473959 L20.4686994,7.3839416 C20.8056532,7.66894833 21,8.08787823 21,8.52920201 L21,21.0833333 C21,22.8738751 20.9795521,23 19.1428571,23 L6.85714286,23 C5.02044787,23 5,22.8738751 5,21.0833333 L5,4.91666667 C5,3.12612489 5.02044787,3 6.85714286,3 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z"
													fill="#000000"
													fill-rule="nonzero"
												/>
											</g>
										</svg>
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">
									My Activities
								</div>
								<div class="text-muted">
									Activities logs
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="separator separator-dashed my-7"></div>

				<div>
					<h5 class="mb-5">Recent Notifications</h5>

					<div class="navi navi-hover scroll my-4" data-scroll="false">
						<a href="javascript:;" class="navi-item">
							<div class="navi-link">
								<div class="navi-icon mr-2">
									<i class="flaticon2-line-chart text-success"></i>
								</div>
								<div class="navi-text">
									<div class="font-weight-bold">New report has been received</div>
									<div class="text-muted">23 hrs ago</div>
								</div>
							</div>
						</a>
						<a href="javascript:;" class="navi-item">
							<div class="navi-link">
								<div class="navi-icon mr-2">
									<i class="flaticon2-paper-plane text-danger"></i>
								</div>
								<div class="navi-text">
									<div class="font-weight-bold">Finance report has been generated</div>
									<div class="text-muted">25 hrs ago</div>
								</div>
							</div>
						</a>
						<a href="javascript:;" class="navi-item">
							<div class="navi-link">
								<div class="navi-icon mr-2">
									<i class="flaticon2-user flaticon2-line- text-success"></i>
								</div>
								<div class="navi-text">
									<div class="font-weight-bold">New order has been received</div>
									<div class="text-muted">2 hrs ago</div>
								</div>
							</div>
						</a>
					</div>
					<div class="navi-item">
						<div class="navi-link">
							<div class="navi-text justify-content-center d-flex">
								<a href="{{ url(admin_uri().'notifications') }}" class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">
									<div class="navi-link">
										<div class="navi-text">
											See More
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
			<div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
				<ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_settings">Settings</a>
					</li>
				</ul>

				<div class="offcanvas-close mt-n1 pr-5">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
						<i class="ki ki-close icon-xs text-muted"></i>
					</a>
				</div>
			</div>

			<div class="offcanvas-content px-10">
				<div class="tab-content">
					<div class="tab-pane fade show pt-3 pr-5 mr-n5 active" id="kt_quick_panel_settings" role="tabpanel">
						<form class="form">
							<div>
								<h5 class="font-weight-bold mb-3">Customer Care</h5>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Enable Notifications:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-success switch-sm">
											<label>
												<input type="checkbox" checked="checked" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Enable Case Tracking:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-success switch-sm">
											<label>
												<input type="checkbox" name="quick_panel_notifications_2" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Support Portal:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-success switch-sm">
											<label>
												<input type="checkbox" checked="checked" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>

							<div class="separator separator-dashed my-6"></div>

							<div class="pt-2">
								<h5 class="font-weight-bold mb-3">Reports</h5>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Generate Reports:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-sm switch-danger">
											<label>
												<input type="checkbox" checked="checked" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Enable Report Export:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-sm switch-danger">
											<label>
												<input type="checkbox" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Allow Data Collection:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-sm switch-danger">
											<label>
												<input type="checkbox" checked="checked" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>

							<div class="separator separator-dashed my-6"></div>

							<div class="pt-2">
								<h5 class="font-weight-bold mb-3">Memebers</h5>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Enable Member singup:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-sm switch-primary">
											<label>
												<input type="checkbox" checked="checked" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Allow User Feedbacks:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-sm switch-primary">
											<label>
												<input type="checkbox" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group mb-0 row align-items-center">
									<label class="col-8 col-form-label">Enable Customer Portal:</label>
									<div class="col-4 d-flex justify-content-end">
										<span class="switch switch-sm switch-primary">
											<label>
												<input type="checkbox" checked="checked" name="select" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal modal-sticky modal-sticky-bottom-right" id="kt_chat_modal" role="dialog" data-backdrop="false">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="card card-custom">
						<div class="card-header align-items-center px-4 py-3">

							<div class="text-left flex-grow-1">
								<div class="dropdown dropdown-inline">

									<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="svg-icon svg-icon-lg">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24" />
													<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
													<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
												</g>
											</svg>
										</span>
									</button>

									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-md">
										<ul class="navi navi-hover py-5">
											<li class="navi-item">
												<a href="javascript:;" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-drop"></i>
													</span>
													<span class="navi-text">New Group</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="javascript:;" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-list-3"></i>
													</span>
													<span class="navi-text">Contacts</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="javascript:;" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-rocket-1"></i>
													</span>
													<span class="navi-text">Groups</span>
													<span class="navi-link-badge">
														<span class="label label-light-primary label-inline font-weight-bold">new</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="javascript:;" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-bell-2"></i>
													</span>
													<span class="navi-text">Calls</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="javascript:;" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-gear"></i>
													</span>
													<span class="navi-text">Settings</span>
												</a>
											</li>
											<li class="navi-separator my-3"></li>
											<li class="navi-item">
												<a href="javascript:;" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-magnifier-tool"></i>
													</span>
													<span class="navi-text">Help</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="javascript:;" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-bell-2"></i>
													</span>
													<span class="navi-text">Privacy</span>
													<span class="navi-link-badge">
														<span class="label label-light-danger label-rounded font-weight-bold">5</span>
													</span>
												</a>
											</li>
										</ul>
									</div>

								</div>
							</div>

							<div class="text-center flex-grow-1">
								<div class="text-dark-75 font-weight-bold font-size-h5">Matt Pears</div>
								<div>
									<span class="label label-dot label-success"></span>
									<span class="font-weight-bold text-muted font-size-sm">Active</span>
								</div>
							</div>

							<div class="text-right flex-grow-1">
								<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-dismiss="modal">
									<i class="ki ki-close icon-1x"></i>
								</button>
							</div>

						</div>

						<div class="card-body">
							<div class="scroll scroll-pull" data-height="330" data-mobile-height="300">
								<div class="messages">
									<div class="d-flex flex-column mb-5 align-items-start">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-circle symbol-40 mr-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_12.jpg') }}" />
											</div>
											<div>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
												<span class="text-muted font-size-sm">2 Hours</span>
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">How likely are you to recommend our company to your friends and family?</div>
									</div>

									<div class="d-flex flex-column mb-5 align-items-end">
										<div class="d-flex align-items-center">
											<div>
												<span class="text-muted font-size-sm">3 minutes</span>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
											</div>
											<div class="symbol symbol-circle symbol-40 ml-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_21.jpg') }}" />
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
									</div>

									<div class="d-flex flex-column mb-5 align-items-start">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-circle symbol-40 mr-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_21.jpg') }}" />
											</div>
											<div>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
												<span class="text-muted font-size-sm">40 seconds</span>
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">Ok, Understood!</div>
									</div>

									<div class="d-flex flex-column mb-5 align-items-end">
										<div class="d-flex align-items-center">
											<div>
												<span class="text-muted font-size-sm">Just now</span>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
											</div>
											<div class="symbol symbol-circle symbol-40 ml-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_21.jpg') }}" />
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">You’ll receive notifications for all issues, pull requests!</div>
									</div>

									<div class="d-flex flex-column mb-5 align-items-start">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-circle symbol-40 mr-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_12.jpg') }}" />
											</div>
											<div>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
												<span class="text-muted font-size-sm">40 seconds</span>
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">You can unwatch this repository immediately by clicking here:
										<a href="javascript:;">https://github.com</a></div>
									</div>

									<div class="d-flex flex-column mb-5 align-items-end">
										<div class="d-flex align-items-center">
											<div>
												<span class="text-muted font-size-sm">Just now</span>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
											</div>
											<div class="symbol symbol-circle symbol-40 ml-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_21.jpg') }}" />
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Discover what students who viewed Learn Figma - UI/UX Design. Essential Training also viewed</div>
									</div>

									<div class="d-flex flex-column mb-5 align-items-start">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-circle symbol-40 mr-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_12.jpg') }}" />
											</div>
											<div>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
												<span class="text-muted font-size-sm">40 seconds</span>
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">Most purchased Business courses during this sale!</div>
									</div>

									<div class="d-flex flex-column mb-5 align-items-end">
										<div class="d-flex align-items-center">
											<div>
												<span class="text-muted font-size-sm">Just now</span>
												<a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
											</div>
											<div class="symbol symbol-circle symbol-40 ml-3">
												<img alt="Pic" src="{{ asset('/media/metronic_v7.1.2/media/users/300_21.jpg') }}" />
											</div>
										</div>
										<div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card-footer align-items-center">
							<textarea class="form-control border-0 p-0" rows="2" placeholder="Type a message"></textarea>
							<div class="d-flex align-items-center justify-content-between mt-5">
								<div class="mr-3">
									<a href="javascript:;" class="btn btn-clean btn-icon btn-md mr-1">
										<i class="flaticon2-photograph icon-lg"></i>
									</a>
									<a href="javascript:;" class="btn btn-clean btn-icon btn-md">
										<i class="flaticon2-photo-camera icon-lg"></i>
									</a>
								</div>
								<div>
									<button type="button" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
		</div>

		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->

		<script src="{{ asset('/js/global/metronic_v7.1.2/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/metronic_v7.1.2/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/scripts.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/clock.js') }}"></script>

		<script>
			var baseUrl = $('body').data('baseurl');
			var cToken = $('body').data('ctoken');

			function clearconsole() {
				console.log(window.console);
				if (window.console) {
					console.clear();
				}
			}
		</script>

        @foreach ($js as $j)
		    <script src="{{ asset('/js/'.$j.'.js') }}"></script>
        @endforeach

		@if (isset($cur_uri[4]) && $cur_uri[4] === 'news' && isset($cur_uri[5]) && ($cur_uri[5] === 'create' || $cur_uri[5] === 'detail'))
			<?php
				$datas = [
					'tags' => $tags,
					'categories' => $categories
				]
			?>
			{{ view( 'admin.news.tagify', $datas ) }}
		@endif

	</body>
</html>
