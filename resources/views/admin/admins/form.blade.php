@extends('admin.layout.app')

@section('content')

<?php 
    $cur_uri = current_uri();
    $request = Session::get('request') ? Session::get('request') : array();
    $action_url = ($cur_uri[5] === 'detail') ? $admin_url.'/update/'.$current['uuid'] : $admin_url.'/save';
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
                                Name 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control"
                                <?php if($cur_uri[5] === 'detail') { ?>
                                    value="{{ isset($request['name']) ? $request['name'] : $current['name'] }}"
                                <?php } elseif($cur_uri[5] !== 'detail') { ?>
                                    value="{{ isset($request['name']) ? $request['name'] : '' }}"
                                <?php } ?>
                            />
                        </div>
                        
                        <div class="form-group">
                            <label>
                                Username 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="username" class="form-control"
                                <?php if($cur_uri[5] === 'detail') { ?>
                                    value="{{ isset($request['username']) ? $request['username'] : $current['slug'] }}"
                                <?php } elseif($cur_uri[5] !== 'detail') { ?>
                                    value="{{ isset($request['username']) ? $request['username'] : '' }}"
                                <?php } ?>
                            />
                        </div>
                        
                        <div class="form-group">
                            <label>
                                Email 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="email" class="form-control"
                                <?php if($cur_uri[5] === 'detail') { ?>
                                    value="{{ isset($request['email']) ? $request['email'] : $current['email'] }}"
                                <?php } elseif($cur_uri[5] !== 'detail') { ?>
                                    value="{{ isset($request['email']) ? $request['email'] : '' }}"
                                <?php } ?>
                            />
                        </div>

                        <div class="form-group">
                            <label>
                                Role
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" name="role">
                                <option value="">Select Role</option>
                                @foreach ($admin_roles as $roles)
                                    <option value="{{ $roles['id'] }}" 
                                        {{ isset($current['role_id']) && $current['role_id'] == $roles['id'] ? 'selected' : '' }}
                                    >{{ $roles['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <?php if($cur_uri[5] === 'create') { ?>
                            <div class="form-group">
                                <label>
                                    Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password" class="form-control" />
                            </div>
                            
                            <div class="form-group">
                                <label>
                                    Re-password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="repassword" class="form-control" />
                            </div>
                        <?php } ?>
                    </div>
                </div>
                
                <?php if($cur_uri[5] === 'detail') { ?>
                    <div class="card card-custom mb-8">
                        <div class="card-header">
                            <h3 class="card-title">
                                Change Password
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>
                                    Old Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="oldpassword" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>
                                    New Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="newpassword" class="form-control" />
                            </div>
                            
                            <div class="form-group">
                                <label>
                                    Type New Password Again
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="renewpassword" class="form-control" />
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
                <?php if($cur_uri[5] === 'detail') { ?>
                    <div class="card card-custom mb-8">
                        <div class="card-header">
                            <h3 class="card-title">
                                Activity Logs
                            </h3>
                        </div>
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