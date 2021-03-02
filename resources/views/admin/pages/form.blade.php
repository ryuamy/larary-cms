@extends('admin.layout.app')

@section('content')

<?php $cur_uri = current_uri(); ?>

<div class="d-flex flex-column-fluid">
    <div class="container">
        <form class="row">
            <div class="col-md-8">
                <div class="card card-custom mb-8">
                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                Title 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" placeholder="Page Title"
                                <?php if($cur_uri[5] === 'detail') { ?>
                                    value="{{ old('title') ? old('title') : $current['name'] }}"
                                <?php } elseif($cur_uri[5] === 'detail') { ?>
                                    value="{{ old('title') }}"
                                <?php } ?>
                            />
                            <?php if($cur_uri[5] === 'detail') { ?>
                                <span class="form-text text-muted d-flex align-items-center">
                                    Permalink: 
                                     <a href="{{ env('APP_URL').'/' }}">
                                        {{ env('APP_URL') }}/<span id="permalink_slug" class="mr-1 d-inline-block">{{ old('slug') ? old('slug') : $current['slug'] }}</span>
                                    </a> 
                                    <input type="text" value="{{ old('slug') ? old('slug') : $current['slug'] }}" 
                                        id="field_permalink_slug" 
                                        class="form-control mr-1 d-none w-auto h-auto pt-0 pb-0" 
                                    />
                                    <a class="label label-success label-inline" href="Javascript:;" id="edit_permalink_slug">
                                        edit
                                    </a>
                                </span>
                            <?php } ?>
                            @error('title')
                                <span class="form-text invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>
                                Content 
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="summernote"
                                name="content"
                            ><?php if($cur_uri[5] === 'detail') { ?>
                                    {{ old('content') ? old('content') : $current['content'] }}
                                <?php } elseif($cur_uri[5] === 'detail') { ?>
                                    {{ old('content') }}
                                <?php } ?></textarea>
                            @error('content')
                                <span class="form-text invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-custom mb-8">
                    <div class="card-header">
                        <h3 class="card-title">
                            Page Setting
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">
                                Status
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="status">
                                <option value="">Select Status</option>
                                <option value="0" {{ isset($current['status']) && $current['status'] == 0 ? 'selected' : '' }}>Inactive</option>
                                <option value="1" {{ isset($current['status']) && $current['status'] == 1 ? 'selected' : '' }}>Active</option>
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
                        <img src="{{ isset($current['featured_image']) && $current['featured_image'] ? asset('/img/'.$current['featured_image']) : asset('/img/admin/layout/default-featured-img.png') }}"
                            alt="Preview Image"
                            title="Preview Image"
                            style="width: 100%; margin-bottom: 2rem"
                            id="preview_feature_img"
                        />

                        <p class="d-none">
                            <input id="upload_feature_image" name="flftrimg" type="file" class="invisible" onchange="preview_image(event, 'preview_feature_img')" />
                        </p>

                        <div>
                            <button type="button" class="btn btn-hover-primary btn-lg btn-block" id="set_feature_image" onclick="set_feature_image()">
                                {{ isset($current['featured_image']) ? 'Change' : 'Set' }} featured image
                            </button>
                        </div>

                        <?php if (isset($current['featured_image'])) { ?>
                            <div>
                                <button type="button" class="btn btn-danger btn-lg btn-block mt-2" id="delete_feature_image" onclick="delete_feature_image('{{ $current['id'] }}')">
                                    Delete current featured image
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection