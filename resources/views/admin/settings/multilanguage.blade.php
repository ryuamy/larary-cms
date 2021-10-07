@extends('admin.layout.app')

@section('content')

<?php
    $cur_uri = current_uri();
    $request = Session::get('request') ? Session::get('request') : array();
    $current_route = \Route::currentRouteName();
    $action_url = $admin_url.'/multilanguage-website/update';
    # FIXME : please remove this 'manual' condition
    $multilanguage = [ 'CN', 'ID', 'GB', 'US' ];
?>

<div class="d-flex flex-column-fluid">
    <div class="container">
        <form class="row form-input" method="POST" action="{{ $action_url }}" id="{{ $table }}" enctype="multipart/form-data">
            <div class="col-md-12 d-flex justify-content-end mb-5">
                @if ( check_admin_access($admindata->role_id, $staticdata['module_slug'], 'edit') == true )
                    <button type="submit" disabled class="btn btn-success btn-dark mr-2" style="cursor: not-allowed;">
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

            <div class="col-md-12 mb-5">
                <div class="alert alert-custom alert-warning d-flex" role="alert">
                    <div class="alert-text" id="alert_message_login">
                        Coming soon...
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">Multilanguage Website</h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>
                                Multilanguage Website
                            </label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" {{ (isset($request['multilanguage_website']) && $request['multilanguage_website'] == 1) || $settings['multilanguage_website'] == 1 ? 'checked' : '' }} name="multilanguage_website">
                                    <span></span>Enable Web Multilanguage
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">Language List</h3>
                    </div>
                    
                    <div class="card-body admin-datatable">
                        <table class="datatable datatable-bordered datatable-head-custom" id="multilanguage_countries">
                            <thead>
                                <tr>
                                    <th title="Name">Name</th>
                                    <th title="ISO Alpha 2 Code">ISO Alpha 2 Code</th>
                                    <th title="ISO Alpha 3 Code">ISO Alpha 3 Code</th>
                                    <th title="Enable/Disable">Enable/Disable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $country)
                                    <tr>        
                                        <td>{{ $country['name'] }}</td>
                                        <td>{{ $country['iso_alpha_2_code'] }}</td>
                                        <td>{{ $country['iso_alpha_3_code'] }}</td>
                                        <td>
                                            <span class="switch switch-outline switch-icon switch-primary">
                                                <label>
                                                    <input type="checkbox" {{ $country['enable_multilanguage'] =='Y' ? 'checked="checked"' : '' }} name="multilanguage[]" value="{{ $country['iso_alpha_2_code'] }}">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @csrf
        </form>
    </div>
</div>

@endsection
