@extends('admin.layout.app')

@section('content')

<?php
    $cur_uri = current_uri();
    $request = Session::get('request') ? Session::get('request') : array();
    $current_route = \Route::currentRouteName();
    $action_url = $admin_url.'/general/update';
?>

<div class="d-flex flex-column-fluid">
    <div class="container">
        <form class="row form-input" method="POST" action="{{ $action_url }}" id="{{ $table }}" enctype="multipart/form-data">
            <div class="col-md-12 d-flex justify-content-end mb-5">
                @if ( check_admin_access($admindata->role_id, $staticdata['module_slug'], 'edit') == true )
                    <button type="submit" class="btn btn-success mr-2">
                        <i class="fas fa-save"></i> Save
                    </button>
                @endif
            </div>

            @if (Session::has('success-message'))
                <div class="col-md-12 mb-5">
                    <div class="alert alert-custom alert-success d-flex show fade" role="alert">
                        <div class="alert-text" id="alert_message_login">
                            {{ Session::get('success-message') }}
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if (Session::has('error-message'))
                <div class="col-md-12 mb-5">
                    <div class="alert alert-custom alert-danger d-flex show fade" role="alert">
                        <div class="alert-text" id="alert_message_login">
                            {{ Session::get('error-message') }}
                            @if (Session::has('errors'))
                                <?php $errors = Session::get('errors'); ?>
                                <ul class="m-0">
                                    @foreach ($errors as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">General Website Setting</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                Site Title
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" class="form-control"
                                value="{{ isset($request['title']) ? $request['title'] : $settings['title'] }}"
                            />
                            <span class="form-text text-muted">
                                Maximum 20 characters include spaces.
                                <br />
                                Example: <label style="color:red">Title</label> | Tagline
                            </span>
                        </div>

                        <div class="form-group">
                            <label>
                                Tagline
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="tagline" class="form-control"
                                value="{{ isset($request['tagline']) ? $request['tagline'] : $settings['tagline'] }}"
                            />
                            <span class="form-text text-muted">
                                Maximum 7 words.
                                <br />
                                Example: Title | <label style="color:red">Tagline</label>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>
                                Separator Between Title and Tagline
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="separator" class="form-control"
                                value="{{ isset($request['separator']) ? $request['separator'] : $settings['separator'] }}"
                            />
                            <span class="form-text text-muted">Example: Title <label style="color:red">|</label> Tagline</span>
                        </div>

                        <div class="form-group">
                            <label>
                                Admin Pagination Limit
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" min="10" name="admin_pagination_limit" class="form-control"
                                value="{{ isset($request['admin_pagination_limit']) ? $request['admin_pagination_limit'] : $settings['admin_pagination_limit'] }}"
                            />
                        </div>

                        <div class="form-group">
                            <label>
                                Timezone
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2" name="timezone">
                                <?php echo $timezone_choice; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                Date Format
                                <span class="text-danger">*</span>
                            </label>
                            <div class="datetime_format">
                                @foreach ($staticdata['date_format'] as $date_format)
                                    <p>
                                        <label class="radio">
                                            <input type="radio" {{ $settings['date_format'] == $date_format ? 'checked' : '' }} value="{{ $date_format }}" name="date_format" />
                                            <span></span>
                                            <i>
                                                {{ date($date_format) }}
                                                <code>{{ $date_format }}</code>
                                            </i>
                                        </label>
                                    </p>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                Time Format
                                <span class="text-danger">*</span>
                            </label>
                            <div class="datetime_format">
                                @foreach ($staticdata['time_format'] as $time_format)
                                    <p>
                                        <label class="radio">
                                            <input type="radio" {{ $settings['time_format'] == $time_format ? 'checked' : '' }} value="{{ $time_format }}" name="time_format" />
                                            <span></span>
                                            <i>
                                                {{ date($time_format) }}
                                                <code>{{ $time_format }}</code>
                                            </i>
                                        </label>
                                    </p>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group d-none">
                            <label>
                                Week Starts On
                                <span class="text-danger">*</span>
                            </label>
                            <select name="start_of_week" readonly class="form-control select2_infinity">
                                <option value="0">Sunday</option>
                                <option value="1" selected="selected">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label>
                                Multilanguage Website
                            </label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" {{ (isset($request['multilanguage_website']) && $request['multilanguage_website'] == 1) || $settings['multilanguage_website'] == 1 ? 'checked' : '' }} name="multilanguage_website">
                                    <span></span>Enable Web Multilanguage
                                </label>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">Permalink Setting</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                News
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-admin-select2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ env('APP_URL') }}/
                                    </span>
                                </div>
                                <select class="form-control select2" name="permalink_news">
                                    <option value="">&nbsp;</option>
                                    @foreach ($pages as $page)
                                        <option value="{{ $page->slug }}"
                                            {{ isset($settings['permalink_news']) && $settings['permalink_news'] == $page->slug ? 'selected' : '' }}
                                        >{{ $page->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="form-text text-muted">
                                Select from pages.
                            </span>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                News Category
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-admin-select2 input-group-admin-select2-text">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ env('APP_URL') }}/
                                    </span>
                                </div>
                                <select class="form-control select2" name="permalink_news">
                                    <option value="">&nbsp;</option>
                                    @foreach ($pages as $page)
                                        <option value="{{ $page->slug }}"
                                            {{ isset($settings['permalink_news']) && $settings['permalink_news'] == $page->slug ? 'selected' : '' }}
                                        >{{ $page->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" 
                                    name="permalink_news_category"
                                    class="form-control"
                                    value="{{ isset($request['permalink_news_category']) ? $request['permalink_news_category'] : $settings['permalink_news_category'] }}"
                                />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                News Tag
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-admin-select2 input-group-admin-select2-text">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ env('APP_URL') }}/
                                    </span>
                                </div>
                                <select class="form-control select2" name="permalink_news">
                                    <option value="">&nbsp;</option>
                                    @foreach ($pages as $page)
                                        <option value="{{ $page->slug }}"
                                            {{ isset($settings['permalink_news']) && $settings['permalink_news'] == $page->slug ? 'selected' : '' }}
                                        >{{ $page->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" 
                                    name="permalink_news_tag"
                                    class="form-control"
                                    value="{{ isset($request['permalink_news_tag']) ? $request['permalink_news_tag'] : $settings['permalink_news_tag'] }}"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @csrf
        </form>
    </div>
</div>

@endsection
