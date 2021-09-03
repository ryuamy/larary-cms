<?php $cur_uri = current_uri(); ?>

<ul class="menu-nav">
    <li class="menu-item {{ isset($cur_uri[4]) && $cur_uri[4] === 'dashboard' ? 'menu-item-active' : '' }}" aria-haspopup="true">
        <a href="{{ url(admin_uri().'dashboard') }}" class="menu-link">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                    </g>
                </svg>
            </span>
            <span class="menu-text">Dashboard</span>
        </a>
    </li>

    <li class="menu-section">
        <h4 class="menu-text">Datas</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>

    @if ( check_admin_access($admindata->role_id, 'pages', 'read') == true )
        <li class="menu-item {{ isset($cur_uri[4]) && $cur_uri[4] === 'pages' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
            <a href="{{ url(admin_uri().'pages') }}" class="menu-link menu-toggle">
                <span class="svg-icon menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <rect fill="#000000" opacity="0.3" x="4" y="4" width="8" height="16" />
                            <path d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z" fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                </span>
                <span class="menu-text">Pages</span>
            </a>
        </li>
    @endif

    @if ( check_admin_access($admindata->role_id, 'news', 'read') == true || check_admin_access($admindata->role_id, 'news_categories', 'read') == true || check_admin_access($admindata->role_id, 'news_tags', 'read') === true )
        <li class="menu-item menu-item-submenu {{ isset($cur_uri[4]) && $cur_uri[4] === 'news' ? 'menu-item-active menu-item-open' : '' }}
            {{ isset($cur_uri[5]) && ($cur_uri[5] === 'news' || $cur_uri[5] === 'categories' || $cur_uri[5] === 'tags') ? 'menu-item-open' : '' }} "
            aria-haspopup="true" data-menu-toggle="hover">

            <a href="Javascript:;" class="menu-link menu-toggle">
                <span class="svg-icon menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <rect fill="#000000" opacity="0.3" x="4" y="4" width="8" height="16" />
                            <path d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z" fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                </span>
                <span class="menu-text">News</span>
                <i class="menu-arrow"></i>
            </a>

            <div class="menu-submenu">
                <i class="menu-arrow"></i>
                <ul class="menu-subnav">
                    @if ( check_admin_access($admindata->role_id, 'news', 'read') == true )
                        <li class="menu-item {{ isset($cur_uri[4]) && $cur_uri[4] === 'news' && !isset($cur_uri[5]) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                            <a href="{{ url(admin_uri().'news') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">News</span>
                            </a>
                        </li>
                    @endif

                    @if ( check_admin_access($admindata->role_id, 'news_categories', 'read') == true )
                        <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'categories' ? 'menu-item-active' : '' }}" aria-haspopup="true">
                            <a href="{{ url(admin_uri().'news/categories') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Categories</span>
                            </a>
                        </li>
                    @endif

                    @if ( check_admin_access($admindata->role_id, 'news_tags', 'read') == true )
                        <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'tags' ? 'menu-item-active' : '' }}" aria-haspopup="true">
                            <a href="{{ url(admin_uri().'news/tags') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Tags</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>
    @endif

    <!--<li class="menu-section">
        <h4 class="menu-text">Messages</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>

    <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'Compose' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'messages/compose') }}" class="menu-link menu-toggle">
            <i class="menu-icon fas fa-paper-plane"></i>
            <span class="menu-text">Compose</span>
        </a>
    </li>

    <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'inbox' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'messages/inbox') }}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M18.1444251,10.8396467 L12,14.1481833 L5.85557487,10.8396467 C5.4908718,10.6432681 5.03602525,10.7797221 4.83964668,11.1444251 C4.6432681,11.5091282 4.77972206,11.9639747 5.14442513,12.1603533 L11.6444251,15.6603533 C11.8664074,15.7798822 12.1335926,15.7798822 12.3555749,15.6603533 L18.8555749,12.1603533 C19.2202779,11.9639747 19.3567319,11.5091282 19.1603533,11.1444251 C18.9639747,10.7797221 18.5091282,10.6432681 18.1444251,10.8396467 Z" fill="#000000"/>
                        <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(11.959697, 3.661508) rotate(-270.000000) translate(-11.959697, -3.661508) "/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Inbox</span>
        </a>
    </li>

    <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'sent' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'messages/sent') }}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M4.5,3 L19.5,3 C20.3284271,3 21,3.67157288 21,4.5 L21,19.5 C21,20.3284271 20.3284271,21 19.5,21 L4.5,21 C3.67157288,21 3,20.3284271 3,19.5 L3,4.5 C3,3.67157288 3.67157288,3 4.5,3 Z M8,5 C7.44771525,5 7,5.44771525 7,6 C7,6.55228475 7.44771525,7 8,7 L16,7 C16.5522847,7 17,6.55228475 17,6 C17,5.44771525 16.5522847,5 16,5 L8,5 Z" fill="#000000"/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Draft</span>
        </a>
    </li>

    <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'sent' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'messages/sent') }}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M18.1444251,10.8396467 L12,14.1481833 L5.85557487,10.8396467 C5.4908718,10.6432681 5.03602525,10.7797221 4.83964668,11.1444251 C4.6432681,11.5091282 4.77972206,11.9639747 5.14442513,12.1603533 L11.6444251,15.6603533 C11.8664074,15.7798822 12.1335926,15.7798822 12.3555749,15.6603533 L18.8555749,12.1603533 C19.2202779,11.9639747 19.3567319,11.5091282 19.1603533,11.1444251 C18.9639747,10.7797221 18.5091282,10.6432681 18.1444251,10.8396467 Z" fill="#000000"/>
                        <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508) "/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Sent</span>
        </a>
    </li>-->

    <li class="menu-section">
        <h4 class="menu-text">Reporting</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>

    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                        <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                        <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                        <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                    </g>
                </svg>
            </span>
            <span class="menu-text">Charts</span>
            <i class="menu-arrow"></i>
        </a>

        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">amCharts</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item" aria-haspopup="true">
                                <a href="features/charts/amcharts/charts" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">amCharts Charts</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="features/charts/amcharts/stock-charts" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">amCharts Stock Charts</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="features/charts/amcharts/maps" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">amCharts Maps</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a href="features/charts/flotcharts" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Flot Charts</span>
                    </a>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a href="features/charts/google-charts" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Google Charts</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                        <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                        <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                        <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                    </g>
                </svg>
            </span>
            <span class="menu-text">Statistic</span>
            <i class="menu-arrow"></i>
        </a>

        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                    <span class="menu-link">
                        <span class="menu-text">Statistic</span>
                    </span>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a href="features/charts/apexcharts" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Apexcharts</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="menu-section">
        <h4 class="menu-text">Users</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>

    <li class="menu-item {{ isset($cur_uri[4]) && $cur_uri[4] === 'admins' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'admins') }}" class="menu-link menu-toggle">
            <i class="menu-icon flaticon2-user-1"></i>
            <span class="menu-text">Admins</span>
        </a>
    </li>

    <li class="menu-item {{ isset($cur_uri[4]) && $cur_uri[4] === 'admin-roles' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'admin-roles') }}" class="menu-link menu-toggle">
            <i class="menu-icon flaticon2-group"></i>
            <span class="menu-text">Admin Roles</span>
        </a>
    </li>

    <li class="menu-item {{ isset($cur_uri[4]) && $cur_uri[4] === 'users' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'users') }}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                    </g>
                </svg>
            </span>
            <span class="menu-text">Users</span>
        </a>
    </li>

    <li class="menu-section">
        <h4 class="menu-text">Layout</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>

    <li class="menu-item menu-item-submenu
            {{ isset($cur_uri[4]) && $cur_uri[4] === 'settings' ? 'menu-item-here' : '' }}
            {{ isset($cur_uri[5]) && ($cur_uri[5] === 'general' || $cur_uri[5] === 'seo' || $cur_uri[5] === 'file-upload') ? 'menu-item-open' : '' }}
        " aria-haspopup="true" data-menu-toggle="hover"
    >
        <a href="javascript:;" class="menu-link menu-toggle">
            <i class="menu-icon flaticon2-laptop"></i>
            <span class="menu-text">Settings</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                    <span class="menu-link">
                        <span class="menu-text">Settings</span>
                    </span>
                </li>
                <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'general' ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url(admin_uri().'settings/general') }}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">General Settings</span>
                    </a>
                </li>
                <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'seo' ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url(admin_uri().'settings/seo') }}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">SEO Website</span>
                    </a>
                </li>
                <li class="menu-item {{ isset($cur_uri[5]) && $cur_uri[5] === 'file-upload' ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url(admin_uri().'settings/file-upload') }}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">File Upload</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="menu-item {{ isset($cur_uri[4]) && $cur_uri[4] === 'themes' ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
        <a href="{{ url(admin_uri().'themes') }}" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000)" />
                        <path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#000000" opacity="0.3" />
                    </g>
                </svg>
            </span>
            <span class="menu-text">Themes</span>
        </a>
    </li>

    <!--<li class="menu-item" aria-haspopup="true">
        <a target="_blank" href="https://preview.keenthemes.com/metronic/demo1/builder" class="menu-link">
            <span class="svg-icon menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                        <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                    </g>
                </svg>
            </span>
            <span class="menu-text">Builder</span>
        </a>
    </li>-->
</ul>
