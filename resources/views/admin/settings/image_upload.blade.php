@extends('admin.layout.app')

@section('content')

<?php
    $cur_uri = current_uri();
    $request = Session::get('request') ? Session::get('request') : array();
    $current_route = \Route::currentRouteName();
    $action_url = $admin_url.'/image-upload/update';
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
                        <h3 class="card-title">Uploading Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                Organize Uploads
                            </label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" {{ (isset($request['organize_uploads']) && $request['organize_uploads'] == 1) || $settings['organize_uploads'] == 1 ? 'checked' : '' }} name="organize_uploads">
                                    <span></span>Organize my uploads into month and year based folders
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                Crop Image To Exact Dimensions
                            </label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" {{ (isset($request['crop_image_to_exact_dimensions']) && $request['crop_image_to_exact_dimensions'] == 1) || $settings['crop_image_to_exact_dimensions'] == 1 ? 'checked' : '' }} name="crop_image_to_exact_dimensions">
                                    <span></span>Crop image to exact dimensions (normally thumbnails are proportional)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">
                            Image sizes
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="form-text text-danger">
                            The sizes listed below determine the maximum dimensions in pixels to use when adding an image to the Media Library.
                        </p>

                        <div class="form-group form-image-size">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Thumbnail Size
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Width
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="100" name="thumbnail_width" class="form-control"
                                        value="{{ isset($request['thumbnail_width']) ? $request['thumbnail_width'] : $settings['thumbnail_width'] }}"
                                    />
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <label class="m-0">
                                        &nbsp;
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Height
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="100" name="thumbnail_height" class="form-control"
                                        value="{{ isset($request['thumbnail_height']) ? $request['thumbnail_height'] : $settings['thumbnail_height'] }}"
                                    />
                                </div>

                            </div>
                        </div>

                        <div class="form-group form-image-size">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Medium Size
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Max Width
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="100" name="medium_max_width" class="form-control"
                                        value="{{ isset($request['medium_max_width']) ? $request['medium_max_width'] : $settings['medium_max_width'] }}"
                                    />
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <label class="m-0">
                                        &nbsp;
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Max Height
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="100" name="medium_max_height" class="form-control"
                                        value="{{ isset($request['medium_max_height']) ? $request['medium_max_height'] : $settings['medium_max_height'] }}"
                                    />
                                </div>

                            </div>
                        </div>

                        <div class="form-group form-image-size">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Large Size
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Max Width
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="100" name="large_max_width" class="form-control"
                                        value="{{ isset($request['large_max_width']) ? $request['large_max_width'] : $settings['large_max_width'] }}"
                                    />
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <label class="m-0">
                                        &nbsp;
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="m-0">
                                        Max Height
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="100" name="large_max_height" class="form-control"
                                        value="{{ isset($request['large_max_height']) ? $request['large_max_height'] : $settings['large_max_height'] }}"
                                    />
                                </div>

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
