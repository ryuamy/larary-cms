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
                @if ( check_admin_access($admindata->role_id, 'pages', 'edit') == true )
                    <button type="submit" class="btn btn-success mr-2">
                        <i class="fas fa-save"></i> Save
                    </button>
                @endif
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
                                <?php } else { ?>
                                    value="{{ isset($request['title']) ? $request['title'] : '' }}"
                                <?php } ?>
                            />
                            <?php if(str_contains($current_route, 'detail')) { ?>
                                <span class="form-text text-muted d-flex align-items-center">
                                    Permalink:&nbsp;
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
                                <?php } else { ?>
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

            <div class="col-md-12">
                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">
                            Meta SEO
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#news_seo_general">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#news_seo_social">Social</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#news_seo_advanced">Advanced</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active" id="news_seo_general" role="tabpanel" aria-labelledby="news_seo_general">
                                <div class="form-group">
                                    <label>
                                        Meta Title
                                    </label>
                                    <input type="text" name="seo_title" class="form-control"
                                        <?php if(str_contains($current_route, 'detail')) { ?>
                                            value="{{ isset($request['seo_title']) ? $request['seo_title'] : $current['seo_title'] }}"
                                        <?php } else { ?>
                                            value="{{ isset($request['seo_title']) ? $request['seo_title'] : '' }}"
                                        <?php } ?>
                                    />
                                    <span class="form-text text-muted">
                                        By default using main title.
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Meta Description
                                    </label>
                                    <textarea name="seo_description" class="form-control"><?php if(str_contains($current_route, 'detail')) { ?>{{ isset($request['seo_description']) ? $request['seo_description'] : $current['seo_description'] }}<?php } else { ?>{{ isset($request['seo_description']) ? $request['seo_description'] : '' }}<?php } ?></textarea>
                                    <span class="form-text text-muted">
                                        By default using content and shorten to 60 character.
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Focus Keyphrase
                                    </label>
                                    <textarea name="seo_focus_keyphrase" class="form-control"><?php if(str_contains($current_route, 'detail')) { ?>{{ isset($request['seo_focus_keyphrase']) ? $request['seo_focus_keyphrase'] : $current['seo_focus_keyphrase'] }}<?php } else { ?>{{ isset($request['seo_focus_keyphrase']) ? $request['seo_focus_keyphrase'] : '' }}<?php } ?></textarea>
                                    <span class="form-text text-muted">
                                        By default using focus keyphrase on seo setting.
                                    </span>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="news_seo_social" role="tabpanel" aria-labelledby="news_seo_social">
                                <ul class="nav nav-tabs nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#news_seo_social_facebook">Facebook</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#news_seo_social_twitter">Twitter</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-5" id="myTabContent">
                                    <div class="tab-pane fade show active" id="news_seo_social_facebook" role="tabpanel" aria-labelledby="news_seo_social_facebook">
                                        <div class="form-group">
                                            <label>
                                            Facebook title
                                            </label>
                                            <input type="text" name="seo_facebook_title" class="form-control"
                                                <?php if(str_contains($current_route, 'detail')) { ?>
                                                    value="{{ isset($request['seo_facebook_title']) ? $request['seo_facebook_title'] : $current['seo_facebook_title'] }}"
                                                <?php } else { ?>
                                                    value="{{ isset($request['seo_facebook_title']) ? $request['seo_facebook_title'] : '' }}"
                                                <?php } ?>
                                            />
                                            <span class="form-text text-muted">
                                                By default using main title
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Facebook Description
                                            </label>
                                            <textarea name="seo_facebook_description" class="form-control"><?php if(str_contains($current_route, 'detail')) { ?>{{ isset($request['seo_facebook_description']) ? $request['seo_facebook_description'] : $current['seo_facebook_description'] }}<?php } else { ?>{{ isset($request['seo_facebook_description']) ? $request['seo_facebook_description'] : '' }}<?php } ?></textarea>
                                            <span class="form-text text-muted">
                                                By default using content and shorten to 60 character.
                                            </span>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="news_seo_social_twitter" role="tabpanel" aria-labelledby="news_seo_social_twitter">
                                        <div class="form-group">
                                            <label>
                                                Twitter title
                                            </label>
                                            <input type="text" name="seo_twitter_title" class="form-control"
                                                <?php if(str_contains($current_route, 'detail')) { ?>
                                                    value="{{ isset($request['seo_twitter_title']) ? $request['seo_twitter_title'] : $current['seo_twitter_title'] }}"
                                                <?php } else { ?>
                                                    value="{{ isset($request['seo_twitter_title']) ? $request['seo_twitter_title'] : '' }}"
                                                <?php } ?>
                                            />
                                            <span class="form-text text-muted">
                                                By default using main title
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Twitter Description
                                            </label>
                                            <textarea name="seo_twitter_description" class="form-control"><?php if(str_contains($current_route, 'detail')) { ?>{{ isset($request['seo_twitter_description']) ? $request['seo_twitter_description'] : $current['seo_twitter_description'] }}<?php } else { ?>{{ isset($request['seo_twitter_description']) ? $request['seo_twitter_description'] : '' }}<?php } ?></textarea>
                                            <span class="form-text text-muted">
                                                By default using content and shorten to 60 character.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="news_seo_advanced" role="tabpanel" aria-labelledby="news_seo_advanced">
                                <div class="form-group">
                                    <label>
                                        Allow search engines to show this in search results?
                                    </label>
                                    <div class="datetime_format d-flex">
                                        <p>
                                            <label class="radio radio-disabled">
                                                <input type="radio" {{ isset($current['seo_allow_search_engine_result']) && $current['seo_allow_search_engine_result'] == 1 ? 'checked' : 'checked' }} value="1" name="seo_allow_search_engine_result" disabled />
                                                <span></span>
                                                <i class="w-auto mr-5">Yes</i>
                                            </label>
                                        </p>
                                        <p>
                                            <label class="radio radio-disabled">
                                                <input type="radio" {{ isset($current['seo_allow_search_engine_result']) && $current['seo_allow_search_engine_result'] == 2 ? 'checked' : '' }} value="2" name="seo_allow_search_engine_result" disabled />
                                                <span></span>
                                                <i class="w-auto mr-5">No</i>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>
                                        Should search engines follow links on this?
                                    </label>
                                    <div class="datetime_format d-flex">
                                        <p>
                                            <label class="radio radio-disabled">
                                                <input type="radio" {{ isset($current['seo_allow_search_engine_follow']) && $current['seo_allow_search_engine_follow'] == 1 ? 'checked' : 'checked' }} value="1" name="seo_allow_search_engine_follow" disabled />
                                                <span></span>
                                                <i class="w-auto mr-5">Yes</i>
                                            </label>
                                        </p>
                                        <p>
                                            <label class="radio radio-disabled">
                                                <input type="radio" {{ isset($current['seo_allow_search_engine_follow']) && $current['seo_allow_search_engine_follow'] == 2 ? 'checked' : '' }} value="2" name="seo_allow_search_engine_follow" disabled />
                                                <span></span>
                                                <i class="w-auto mr-5">No</i>
                                            </label>
                                        </p>
                                    </div>
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
