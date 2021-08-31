@extends('admin.layout.app')

@section('content')

<?php
    $cur_uri = current_uri();
    $request = Session::get('request') ? Session::get('request') : array();
    $current_route = \Route::currentRouteName();
    $action_url = (str_contains($current_route, 'detail')) ? $admin_url.'/update/'.$current['uuid'] : $admin_url.'/save';
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

            <div class="col-md-8">
                <div class="card card-custom mb-8">
                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                Title
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" class="form-control"
                                <?php if(str_contains($current_route, 'detail')) { ?>
                                    value="{{ isset($request['title']) ? $request['title'] : $current['name'] }}"
                                <?php } elseif($cur_uri[5] !== 'detail') { ?>
                                    value="{{ isset($request['title']) ? $request['title'] : '' }}"
                                <?php } ?>
                            />
                            <?php if(str_contains($current_route, 'detail')) { ?>
                                <span class="form-text text-muted d-flex align-items-center">
                                    Permalink:
                                     <a href="{{ env('APP_URL').'/' }}">
                                        {{ env('APP_URL') }}/<span id="permalink_slug" class="mr-1 d-inline-block">{{ isset($request['permalink']) ? $request['permalink'] : $current['slug'] }}</span>
                                    </a>
                                    <input type="text" value="{{ isset($request['permalink']) ? $request['permalink'] : $current['slug'] }}"
                                        id="field_permalink_slug"
                                        class="form-control mr-1 d-none w-auto h-auto pt-0 pb-0"
                                        name="permalink"
                                    />
                                    <a class="label label-success label-inline" href="Javascript:;" id="edit_permalink_slug">
                                        edit
                                    </a>
                                </span>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <label>
                                Content
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="summernote"
                                name="content"
                            ><?php if(str_contains($current_route, 'detail')) { ?>
                                    {{ isset($request['content']) ? $request['content'] : $current['content'] }}
                                <?php } elseif($cur_uri[5] !== 'detail') { ?>
                                    {{ isset($request['content']) ? $request['content'] : '' }}
                                <?php } ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">
                            Setting
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">
                                Status
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Select Status</option>
                                @foreach ($staticdata['default_status'] as $kS => $status)
                                    @if ($kS != 2)
                                        <option value="{{ $kS }}"
                                            {{ isset($current['status']) && $current['status'] == $kS ? 'selected' : '' }}
                                        >{{ $status }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                Categories
                            </label>
                            <input id="categories_tagify" class="form-control tagify" name='categories' placeholder='type...' value='' autofocus="" />
                        </div>

                        <div class="form-group">
                            <label>
                                Tags
                            </label>
                            <input id="tags_tagify" class="form-control tagify" name="tags" placeholder='type...' value='' />
                        </div>
                    </div>
                </div>

                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">
                            Featured Image
                        </h3>
                    </div>
                    <div class="card-body">
                        <img src="{{ isset($current['featured_image']) && $current['featured_image'] ? asset($current['featured_image']) : asset('/media/admin/layout/no-image-available.png') }}"
                            alt="Preview Image"
                            title="Preview Image"
                            style="width: 100%; margin-bottom: 2rem"
                            id="preview_feature_img"
                        />

                        <p class="d-none">
                            <input id="upload_feature_image" name="featured" type="file" class="invisible" onchange="preview_image(event, 'preview_feature_img')" value="{{ isset($current['featured_image']) && $current['featured_image'] ? $current['featured_image'] : '' }}" />
                        </p>

                        <div>
                            <button type="button" class="btn btn-hover-primary btn-lg btn-block" id="set_feature_image">
                                {{ isset($current['featured_image']) ? 'Change' : 'Set' }} featured image
                            </button>
                        </div>

                        <?php if (isset($current['featured_image'])) { ?>
                            <div>
                                <button type="button" class="btn btn-danger btn-lg btn-block mt-2" id="delete_feature_image">
                                    Delete current featured image
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            @csrf
        </form>
    </div>
</div>

@endsection
