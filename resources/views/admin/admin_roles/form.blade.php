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

            <?php
                if(str_contains($current_route, 'create') || (str_contains($current_route, 'detail') && ($current['slug'] !== 'super_admin' && $current['slug'] !== 'admin' && $current['slug'] !== 'editor'))) {
                    $left_div_class = 'col-md-8';
                } else {
                    $left_div_class = 'col-md-12';
                }
            ?>
            <div class="{{ $left_div_class }}">
                <div class="card card-custom mb-8">
                    <div class="card-body">
                        <div class="form-group">
                            <label>
                                Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control"
                                <?php if(str_contains($current_route, 'detail')) { ?>
                                    value="{{ isset($request['name']) ? $request['name'] : $current['name'] }}"
                                <?php } elseif($cur_uri[5] !== 'detail') { ?>
                                    value="{{ isset($request['name']) ? $request['name'] : '' }}"
                                <?php } ?>
                            />
                        </div>
                    </div>
                </div>

                <?php if(str_contains($current_route, 'create') || (str_contains($current_route, 'detail') && ($current['slug'] !== 'super_admin' && $current['slug'] !== 'admin' && $current['slug'] !== 'editor'))) { ?>
                    <div class="card card-custom mb-8">
                        <div class="card-header">
                            <h3 class="card-title">
                                Modules
                            </h3>
                        </div>
                        <div class="my-5 mr-0">
                            <div class="card-body" style="height:150px; overflow-y:scroll; overflow-x:auto;">
                                <div class="form-group">
                                    @foreach ($modules as $key => $module)
                                        <div class="row">
                                            <div class="col-4">
                                                <label>{{ $module->name }}</label>
                                                <input type="checkbox"
                                                    class="d-none"
                                                    <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id) === true) ? 'checked' : ''; ?>
                                                    value="{{ $module->id }}"
                                                    id="modules_{{ $module->slug }}_id"
                                                    name="modules[{{ $key }}][module_id]"
                                                />
                                                <input type="checkbox"
                                                    class="d-none"
                                                    <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id) === true) ? 'checked' : ''; ?>
                                                    value="{{ $module->slug }}"
                                                    id="modules_{{ $module->slug }}"
                                                    name="modules[{{ $key }}][name]"
                                                />
                                            </div>

                                            <div class="col-2">
                                                <div class="checkbox-list">
                                                    <label class="checkbox">
                                                        <input type="checkbox"
                                                            value="read"
                                                            class="modules_rules modules_rules_read modules_{{ $module->slug }}_read"
                                                            <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id, 'read') === true) ? 'checked' : ''; ?>
                                                            data-key="{{ $module->slug }}"
                                                            name="modules[{{ $key }}][rules][]"
                                                        />
                                                        <span></span>Read
                                                    </label>
                                                </div>
                                            </div>

                                            @if ($module->slug !== 'countries' && $module->slug !== 'cities' && $module->slug !== 'provinces')
                                                <div class="col-2">
                                                    <div class="checkbox-list">
                                                        <label class="checkbox <?php echo (check_admin_role_module($admindata->id, $module->id) === true) ? '' : 'checkbox-disabled'; ?> label_modules_{{ $module->slug }}_add">
                                                            <input type="checkbox"
                                                                value="add"
                                                                <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id) === true) ? '' : 'disabled'; ?>
                                                                <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id, 'add') === true) ? 'checked' : ''; ?>
                                                                class="modules_rules modules_{{ $module->slug }}_add"
                                                                data-key="{{ $module->slug }}"
                                                                name="modules[{{ $key }}][rules][]"
                                                            />
                                                            <span></span>Add
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="checkbox-list">
                                                        <label class="checkbox <?php echo (check_admin_role_module($admindata->id, $module->id) === true) ? '' : 'checkbox-disabled'; ?> label_modules_{{ $module->slug }}_edit">
                                                            <input type="checkbox"
                                                                value="edit"
                                                                <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id) === true) ? '' : 'disabled'; ?>
                                                                <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id, 'edit') === true) ? 'checked' : ''; ?>
                                                                class="modules_rules modules_{{ $module->slug }}_edit"
                                                                data-key="{{ $module->slug }}"
                                                                name="modules[{{ $key }}][rules][]"
                                                            />
                                                            <span></span>Edit
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="checkbox-list">
                                                        <label class="checkbox <?php echo (check_admin_role_module($admindata->id, $module->id) === true) ? '' : 'checkbox-disabled'; ?> label_modules_{{ $module->slug }}_delete">
                                                            <input type="checkbox"
                                                                value="delete"
                                                                <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id) === true) ? '' : 'disabled'; ?>
                                                                <?php echo (str_contains($current_route, 'detail') && check_admin_role_module($admindata->id, $module->id, 'delete') === true) ? 'checked' : ''; ?>
                                                                class="modules_rules modules_{{ $module->slug }}_delete"
                                                                data-key="{{ $module->slug }}"
                                                                name="modules[{{ $key }}][rules][]"
                                                            />
                                                            <span></span>Delete
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php if(str_contains($current_route, 'create') || (str_contains($current_route, 'detail') && ($current['slug'] !== 'super_admin' && $current['slug'] !== 'admin' && $current['slug'] !== 'editor'))) { ?>
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
                </div>
            <?php } ?>

            <div class="col-md-12">
                <?php if(str_contains($current_route, 'detail')) { ?>
                    <div class="card card-custom mb-8">
                        <div class="card-header">
                            <h3 class="card-title">
                                Admin List
                            </h3>
                        </div>
                        <?php /** FIXME : datatable pagination not work */ ?>
                        <div class="card-body">
                            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable" data-uuid="{{ $current['id'] }}"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            @csrf
        </form>
    </div>
</div>

@endsection
