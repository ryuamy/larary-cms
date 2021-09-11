@extends('admin.layout.app')

@section('content')

<?php
    $cur_uri = current_uri();
    $request = Session::get('request') ? Session::get('request') : array();
    $current_route = \Route::currentRouteName();
    $action_url = $admin_url.'/seo/update';
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
                        <h3 class="card-title">Meta Website</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                Meta description
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" class="form-control">{{ isset($request['description']) ? $request['description'] : $settings['description'] }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                Focus Keyphrase
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="focus_keyphrase" class="form-control">{{ isset($request['focus_keyphrase']) ? $request['focus_keyphrase'] : $settings['focus_keyphrase'] }}</textarea>
                            <span class="form-text text-muted">
                                Focus keyphrase must be included in description.
                            </span>
                        </div>

                        <div class="form-group">
                            <label>
                                Search Engine Visibility
                            </label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" {{ (isset($request['search_engine_visibility']) && $request['search_engine_visibility'] == 1) || $settings['search_engine_visibility'] == 1 ? 'checked' : '' }} name="search_engine_visibility">
                                    <span></span>Discourage search engines from indexing this site
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">
                            Webmaster Tools
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="form-text text-danger">
                            All fields in this section are required if "Search Engine Visibility" field is checked.
                        </p>
                        <div class="form-group">
                            <label>
                                Google Verification Code
                            </label>
                            <input type="text" name="google_verification_code" class="form-control"
                                value="{{ isset($request['google_verification_code']) ? $request['google_verification_code'] : $settings['google_verification_code'] }}"
                            />
                            <span class="form-text text-muted">
                                Get your Google verification code in
                                <a href="https://www.google.com/webmasters/verification/verification?hl=en&tid=alternate&siteUrl={{ env('APP_URL') }}">Google Search Console</a>.
                            </span>
                        </div>

                        <div class="form-group">
                            <label>
                                Bing Verification Code
                            </label>
                            <input type="text" name="bing_verification_code" class="form-control"
                                value="{{ isset($request['bing_verification_code']) ? $request['bing_verification_code'] : $settings['bing_verification_code'] }}"
                            />
                            <span class="form-text text-muted">
                                Get your Bing verification code in
                                <a href="https://www.bing.com/toolbox/webmaster/#/Dashboard/?url={{ env('APP_URL') }}">Bing Webmaster Tools</a>.
                            </span>
                        </div>

                    </div>
                </div>

                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">Schema</h3>
                        {{-- https://schema.org/ --}}
                    </div>
                    <div class="card-body">
                        <p>Coming Soon...</p>
                    </div>
                </div>
            </div>

            @csrf
        </form>
    </div>
</div>

@endsection
