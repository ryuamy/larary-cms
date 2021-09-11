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
                @if ( check_admin_access($admindata->role_id, $staticdata['module_slug'], 'edit') == true )
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

                            <?php if(str_contains($current_route, 'detail')) { ?>
                                <span class="form-text text-muted d-flexs d-none align-items-center">
                                    Permalink:&nbsp;
                                     <a href="{{ env('APP_URL').'/' }}{{ isset($request['permalink']) ? $request['permalink'] : $current['slug'] }}">
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
                    </div>
                </div>

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
                                    <?php
                                        /** FIXME : rapikan code */

                                        $is_module_id_checked = '';
                                        $is_module_name_checked = '';

                                        $is_module_rule_read_checked = '';
                                        $is_checkbox_disabled_read = '';
                                        $is_module_rule_read_disabled = '';

                                        $is_module_rule_add_checked = '';
                                        $is_checkbox_disabled_add = '';
                                        $is_module_rule_add_disabled = '';

                                        $is_module_rule_edit_checked = '';
                                        $is_checkbox_disabled_edit = '';
                                        $is_module_rule_edit_disabled = '';

                                        $is_module_rule_delete_checked = '';
                                        $is_checkbox_disabled_delete = '';
                                        $is_module_rule_delete_disabled = '';

                                        //----------------------------------------------------------------------//
                                        if(
                                            isset($current) && (
                                                check_admin_access($current['id'], $module->slug) == true || (
                                                    $current['slug'] == 'super_admin' || (
                                                        $current['slug'] == 'admin' && (
                                                            $module->slug !== 'modules'
                                                        )
                                                    ) || (
                                                        $current['slug'] == 'editor' && (
                                                            $module->slug !== 'admins' &&
                                                            $module->slug !== 'admin_roles' &&
                                                            $module->slug !== 'modules' &&
                                                            $module->slug !== 'general_settings' &&
                                                            $module->slug !== 'seo_website_settings' &&
                                                            $module->slug !== 'file_upload_settings' &&
                                                            $module->slug !== 'users'
                                                        )
                                                    )
                                                )
                                            )
                                        ) {
                                            $is_module_id_checked = 'checked';
                                            $is_module_name_checked = 'checked';
                                            $is_module_rule_read_checked = 'checked';
                                        }

                                        if(
                                            isset($current) && (
                                                check_admin_access($current['id'], $module->slug, 'add') == true || (
                                                    $current['slug'] == 'super_admin' || (
                                                        $current['slug'] == 'admin' && (
                                                            $module->slug !== 'modules'
                                                        )
                                                    ) || (
                                                        $current['slug'] == 'editor' && (
                                                            $module->slug !== 'admins' &&
                                                            $module->slug !== 'admin_roles' &&
                                                            $module->slug !== 'modules' &&
                                                            $module->slug !== 'general_settings' &&
                                                            $module->slug !== 'seo_website_settings' &&
                                                            $module->slug !== 'file_upload_settings' &&
                                                            $module->slug !== 'users'
                                                        )
                                                    )
                                                )
                                            )
                                        ) {
                                            $is_module_rule_add_checked = 'checked';
                                        }

                                        if(
                                            isset($current) && (
                                                check_admin_access($current['id'], $module->slug, 'edit') == true || (
                                                    $current['slug'] == 'super_admin' || (
                                                        $current['slug'] == 'admin' && (
                                                            $module->slug !== 'modules'
                                                        )
                                                    ) || (
                                                        $current['slug'] == 'editor' && (
                                                            $module->slug !== 'admins' &&
                                                            $module->slug !== 'admin_roles' &&
                                                            $module->slug !== 'modules' &&
                                                            $module->slug !== 'general_settings' &&
                                                            $module->slug !== 'seo_website_settings' &&
                                                            $module->slug !== 'file_upload_settings' &&
                                                            $module->slug !== 'users'
                                                        )
                                                    )
                                                )
                                            )
                                        ) {
                                            $is_module_rule_edit_checked = 'checked';
                                        }

                                        if(
                                            isset($current) && (
                                                check_admin_access($current['id'], $module->slug, 'delete') == true || (
                                                    $current['slug'] == 'super_admin' || (
                                                        $current['slug'] == 'admin' && (
                                                            $module->slug !== 'modules'
                                                        )
                                                    )
                                                )
                                            )
                                        ) {
                                            $is_module_rule_delete_checked = 'checked';
                                        }
                                        //----------------------------------------------------------------------//

                                        //----------------------------------------------------------------------//
                                        if (
                                            isset($current) && (
                                                $current['slug'] === 'super_admin' ||
                                                $current['slug'] === 'admin' ||
                                                $current['slug'] === 'editor'
                                            )
                                        ) {
                                            $is_module_rule_read_disabled = 'disabled';
                                            $is_checkbox_disabled_read = 'checkbox-disabled';
                                        }

                                        if (
                                            str_contains($current_route, 'create') || (
                                                str_contains($current_route, 'detail') &&
                                                isset($current) &&
                                                check_admin_access($current['id'], $module->slug, 'add') == false ||
                                                (
                                                    $current['slug'] == 'super_admin' ||
                                                    $current['slug'] == 'admin' ||
                                                    $current['slug'] == 'editor'
                                                )
                                            )
                                        ) {
                                            $is_module_rule_add_disabled = 'disabled';
                                            $is_checkbox_disabled_add = 'checkbox-disabled';
                                        }

                                        if (
                                            str_contains($current_route, 'create') || (
                                                str_contains($current_route, 'detail') &&
                                                isset($current) &&
                                                check_admin_access($current['id'], $module->slug, 'edit') == false ||
                                                (
                                                    $current['slug'] == 'super_admin' ||
                                                    $current['slug'] == 'admin' ||
                                                    $current['slug'] == 'editor'
                                                )
                                            )
                                        ) {
                                            $is_module_rule_edit_disabled = 'disabled';
                                            $is_checkbox_disabled_edit = 'checkbox-disabled';
                                        }

                                        if (
                                            str_contains($current_route, 'create') || (
                                                str_contains($current_route, 'detail') &&
                                                isset($current) &&
                                                check_admin_access($current['id'], $module->slug, 'delete') == false ||
                                                (
                                                    $current['slug'] == 'super_admin' ||
                                                    $current['slug'] == 'admin' ||
                                                    $current['slug'] == 'editor'
                                                )
                                            )
                                        ) {
                                            $is_module_rule_delete_disabled = 'disabled';
                                            $is_checkbox_disabled_delete = 'checkbox-disabled';
                                        }
                                        //----------------------------------------------------------------------//
                                    ?>

                                    <div class="row" style="border-bottom:1px dashed #EBEDF3; padding:8px 0px;">
                                        <div class="col-4">
                                            <label class="m-0">{{ $module->name }}</label>

                                            <input type="checkbox"
                                                class="d-none"
                                                {{ $is_module_id_checked }}
                                                value="{{ $module->id }}"
                                                id="modules_{{ $module->slug }}_id"
                                                name="modules[{{ $key }}][module_id]"
                                            />

                                            <input type="checkbox"
                                                class="d-none"
                                                {{ $is_module_name_checked }}
                                                value="{{ $module->slug }}"
                                                id="modules_{{ $module->slug }}"
                                                name="modules[{{ $key }}][name]"
                                            />
                                        </div>

                                        <div class="col-2">
                                            <div class="checkbox-list">
                                                <label class="checkbox {{ $is_checkbox_disabled_read }}">
                                                    <input type="checkbox"
                                                        value="read"
                                                        class="modules_rules modules_rules_read modules_{{ $module->slug }}_read"
                                                        {{ $is_module_rule_read_checked }}
                                                        {{ $is_module_rule_read_disabled }}
                                                        data-key="{{ $module->slug }}"
                                                        name="modules[{{ $key }}][rules][]"
                                                    />
                                                    <span></span>Read
                                                </label>
                                            </div>

                                            <?php
                                                /** FIXME : rapikan code */
                                                if(
                                                    isset($current) && (
                                                        $current['slug'] == 'super_admin' || (
                                                            $current['slug'] == 'admin' && (
                                                                $module->slug !== 'modules'
                                                            )
                                                        ) || (
                                                            $current['slug'] == 'editor' && (
                                                                $module->slug !== 'admins' &&
                                                                $module->slug !== 'admin_roles' &&
                                                                $module->slug !== 'modules' &&
                                                                $module->slug !== 'general_settings' &&
                                                                $module->slug !== 'seo_website_settings' &&
                                                                $module->slug !== 'file_upload_settings' &&
                                                                $module->slug !== 'users'
                                                            )
                                                        )
                                                    )
                                                ) {
                                            ?>
                                                <input type="checkbox"
                                                    value="read"
                                                    class="d-none"
                                                    checked
                                                    name="modules[{{ $key }}][rules][]"
                                                />
                                            <?php } ?>
                                        </div>

                                        <?php
                                            /** FIXME : rapikan code */
                                            if (
                                                $module->slug !== 'countries' &&
                                                $module->slug !== 'cities' &&
                                                $module->slug !== 'provinces' &&
                                                $module->slug !== 'general_settings' &&
                                                $module->slug !== 'seo_website_settings' &&
                                                $module->slug !== 'file_upload_settings'
                                            ) {
                                        ?>
                                            <div class="col-2">
                                                <div class="checkbox-list">
                                                    <label class="checkbox {{ $is_checkbox_disabled_add }} label_modules_{{ $module->slug }}_add">
                                                        <input type="checkbox"
                                                            value="add"
                                                            class="modules_rules modules_{{ $module->slug }}_add"
                                                            {{ $is_module_rule_add_checked }}
                                                            {{ $is_module_rule_add_disabled }}
                                                            data-key="{{ $module->slug }}"
                                                            name="modules[{{ $key }}][rules][]"
                                                        />
                                                        <span></span>Add
                                                    </label>
                                                </div>

                                                <?php
                                                    /** FIXME : rapikan code */
                                                    if(
                                                        isset($current) && (
                                                            $current['slug'] == 'super_admin' || (
                                                                $current['slug'] == 'admin' && (
                                                                    $module->slug !== 'modules'
                                                                )
                                                            ) || (
                                                                $current['slug'] == 'editor' && (
                                                                    $module->slug !== 'admins' &&
                                                                    $module->slug !== 'admin_roles' &&
                                                                    $module->slug !== 'modules' &&
                                                                    $module->slug !== 'general_settings' &&
                                                                    $module->slug !== 'seo_website_settings' &&
                                                                    $module->slug !== 'file_upload_settings' &&
                                                                    $module->slug !== 'users'
                                                                )
                                                            )
                                                        )
                                                    ) {
                                                ?>
                                                    <input type="checkbox"
                                                        value="add"
                                                        class="d-none"
                                                        checked
                                                        name="modules[{{ $key }}][rules][]"
                                                    />
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-2">&nbsp;</div>
                                        <?php } ?>

                                        <?php
                                            /** FIXME : rapikan code */
                                            if (
                                                $module->slug !== 'countries' &&
                                                $module->slug !== 'cities' &&
                                                $module->slug !== 'provinces'
                                            ) {
                                        ?>
                                            <div class="col-2">
                                                <div class="checkbox-list">
                                                    <label class="checkbox {{ $is_checkbox_disabled_edit }} label_modules_{{ $module->slug }}_edit">
                                                        <input type="checkbox"
                                                            value="edit"
                                                            class="modules_rules modules_{{ $module->slug }}_edit"
                                                            {{ $is_module_rule_edit_checked }}
                                                            {{ $is_module_rule_edit_disabled }}
                                                            data-key="{{ $module->slug }}"
                                                            name="modules[{{ $key }}][rules][]"
                                                        />
                                                        <span></span>Edit
                                                    </label>
                                                </div>

                                                <?php
                                                    /** FIXME : rapikan code */
                                                    if(
                                                        isset($current) && (
                                                            $current['slug'] == 'super_admin' || (
                                                                $current['slug'] == 'admin' && (
                                                                    $module->slug !== 'modules'
                                                                )
                                                            ) || (
                                                                $current['slug'] == 'editor' && (
                                                                    $module->slug !== 'admins' &&
                                                                    $module->slug !== 'admin_roles' &&
                                                                    $module->slug !== 'modules' &&
                                                                    $module->slug !== 'general_settings' &&
                                                                    $module->slug !== 'seo_website_settings' &&
                                                                    $module->slug !== 'file_upload_settings' &&
                                                                    $module->slug !== 'users'
                                                                )
                                                            )
                                                        )
                                                    ) {
                                                ?>
                                                    <input type="checkbox"
                                                        value="edit"
                                                        class="d-none"
                                                        checked
                                                        name="modules[{{ $key }}][rules][]"
                                                    />
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <?php
                                            /** FIXME : rapikan code */
                                            if (
                                                $module->slug !== 'countries' &&
                                                $module->slug !== 'cities' &&
                                                $module->slug !== 'provinces' &&
                                                $module->slug !== 'general_settings' &&
                                                $module->slug !== 'seo_website_settings' &&
                                                $module->slug !== 'file_upload_settings'
                                            ) {
                                        ?>
                                            <div class="col-2">
                                                <div class="checkbox-list">
                                                    <label class="checkbox {{ $is_checkbox_disabled_delete }} label_modules_{{ $module->slug }}_delete">
                                                        <input type="checkbox"
                                                            value="delete"
                                                            {{ $is_module_rule_delete_checked }}
                                                            {{ $is_module_rule_delete_disabled }}
                                                            class="modules_rules modules_{{ $module->slug }}_delete"
                                                            data-key="{{ $module->slug }}"
                                                            name="modules[{{ $key }}][rules][]"
                                                        />
                                                        <span></span>Delete
                                                    </label>
                                                </div>

                                                <?php
                                                    /** FIXME : rapikan code */
                                                    if(
                                                        isset($current) && (
                                                            $current['slug'] == 'super_admin' || (
                                                                $current['slug'] == 'admin' && (
                                                                    $module->slug !== 'modules'
                                                                )
                                                            )
                                                        )
                                                    ) {
                                                ?>
                                                    <input type="checkbox"
                                                        value="delete"
                                                        class="d-none"
                                                        checked
                                                        name="modules[{{ $key }}][rules][]"
                                                    />
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                @endforeach
                            </div>
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
            </div>

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
