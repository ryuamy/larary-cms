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
                <button type="submit" class="btn btn-success mr-2">
                    <i class="fas fa-save"></i> Save
                </button>
                <a class="btn btn-dark" href="{{ $admin_url }}">
                    Cancel
                </a>
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
                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                Description
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

                    </div>
                </div>
            </div>

            @csrf
        </form>
    </div>
</div>

@endsection
