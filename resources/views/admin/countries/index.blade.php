@extends('admin.layout.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header pt-6 pb-6 pr-0">
                <div class="row bx-bulk-action w-100 align-items-center">
                    <div class="col-sm-12 col-md-5">&nbsp;</div>

                    <div class="col-sm-12 col-md-7">
                        <div class="d-flex justify-content-end">
                            {{ view( "admin.layout.export_button" ) }}

                            <button class="btn {{ isset($_GET['action']) ? 'btn-light-success' : 'btn-success' }} mr-2 font-weight-bolder" id="btn-filter" style="padding-left: 9px;">
                                <span class="svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 20 20" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="20" height="20"/>
                                            <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z"
                                                fill="#ffffff"
                                            />
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 card card-custom mb-8 w-100 {{ isset($_GET['action']) ? 'd-flex' : 'd-none' }}" id="filter">
                    <div class="card-body">
                        <h3 class="card-label mb-7">
                            Filter {{ $meta['heading'] }}
                        </h3>

                        <form>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>
                                            Name
                                        </label>
                                        <input type="text" class="form-control" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>
                                            Search Condition
                                        </label>
                                        <select name="condition" class="form-control">
                                            <option value="like" {{ isset($_GET['condition']) && $_GET['condition'] == 'like' ? 'selected' : '' }}>Like</option>
                                            <option value="equal" {{ isset($_GET['condition']) && $_GET['condition'] == 'equal' ? 'selected' : '' }}>Equal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>
                                            Status
                                        </label>
                                        <select name="status" class="form-control">
                                            <option value="all" {{ isset($_GET['status']) && $_GET['status'] == 'all' ? 'selected' : '' }}>All</option>
                                            <option value="1" {{ isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ isset($_GET['status']) && $_GET['status'] == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <button type="submit" class="btn btn-success mr-2" name="action" value="search">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1"
                                        >
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                    </span>
                                    Search
                                </button>
                                <a href="{{ url($admin_url) }}" class="btn btn-secondary">
                                    See All
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-12 col-md-7">
                        <?php if($total != 0) { ?>
                            <div class="admin-pagination">
                                <?php echo $pagination['view']; ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-end">
                        <select name="limit" class="w-auto mr-2 form-control form-control-solid form-control-sm page-limit">
                            <option value="20">20</option>
                            <option value="50" {{ isset($_GET['limit']) && $_GET['limit'] == 50 ? 'selected' : '' }}>50</option>
                            <option value="70" {{ isset($_GET['limit']) && $_GET['limit'] == 70 ? 'selected' : '' }}>70</option>
                            <option value="100" {{ isset($_GET['limit']) && $_GET['limit'] == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                            <?php if($total != 0) { ?>
                                Showing {{ $pagination['showing_from'] }}
                                to {{ $pagination['showing_to'] }}
                                of
                            <?php } ?>
                            {{ $total }} entries
                        </div>
                    </div>
                </div>

                <form id="table-data" class="table-responsive">
                    <table id="{{ $table }}" class="table table-vertical-center table-head-custom table-foot-custom table-checkable table-list" style="width:1800px;">
                        <thead>
                            <tr>
                                <?php foreach($table_head as $khead => $vhead) { ?>
                                    <th class="{{ $khead }} {{ ( (isset($_GET['order']) && $_GET['order'] === $khead) ) ? "active" : "" }} {{ $vhead['class'] }}">
                                        <a <?php echo (!empty($vhead['order'])) ? 'href="'.$pagination['base_sort_link'].$vhead['order'].'"' : ''; ?>>
                                            {{  ucwords( str_replace("_", " ", $khead) ) }} <?php echo (!empty($vhead['order'])) ? "<span></span>" : ''; ?>
                                        </a>
                                    </th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <?php foreach($table_head as $khead => $vhead) { ?>
                                    <th class="{{ $khead }} {{ ( (isset($_GET['order']) && $_GET['order'] === $khead) ) ? "active" : "" }} {{ $vhead['class'] }}">
                                        <a <?php echo (!empty($vhead['order'])) ? 'href="'.$pagination['base_sort_link'].$vhead['order'].'"' : ''; ?>>
                                            {{ ucwords( str_replace("_", " ", $khead) ) }} <?php echo (!empty($vhead['order'])) ? "<span></span>" : ''; ?>
                                        </a>
                                    </th>
                                <?php } ?>
                            </tr>
                        </tfoot>

                        <tbody>
                            <?php if(count($list) > 0) { ?>
                                <?php foreach($list as $dt) { ?>
                                    <tr>
                                        <td>
                                            {{ $dt['name'] }}
                                        </td>
                                        <td>
                                            {{ $dt['iso_alpha_2_code'] }}
                                        </td>
                                        <td>
                                            {{ $dt['iso_alpha_3_code'] }}
                                        </td>
                                        <td>
                                            {{ $dt['un_code'] }}
                                        </td>
                                        <td>
                                            {{ $dt['phone_code'] }}
                                        </td>
                                        <td>
                                            <a href="{{ $dt['flag'] ? $dt['flag'] : 'Javascript:;'}}" {{ $dt['flag'] ? 'target="_blank"' : '' }}>
                                                <img src="{{ $dt['flag'] ? asset($dt['flag']) : asset('/media/admin/layout/no-image-available.png') }}"
                                                    alt="{{ $dt['name'] }}"
                                                    width="80"
                                                />
                                            </a>
                                        </td>
                                        <td>
                                            {{ $dt['capital_city'] }}
                                        </td>
                                        <td class="text-center">
                                            <span class="status-{{ $dt['status'] }}">
                                                {{ $staticdata['default_status'][$dt['status']] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{  date("Y-m-d hA", strtotime($dt['created_at'])) }}
                                        </td>
                                        <td class="text-center">
                                            {{  date("Y-m-d hA", strtotime($dt['updated_at'])) }}
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="{{ $admindata->role_id === 1 || $admindata->role_id === 2 ? $table_body_colspan+1 : $table_body_colspan }}" style="text-align:center;">
                                        No Data
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>

                <div class="row align-items-center mt-3">
                    <div class="col-sm-12 col-md-7">
                        <?php if($total != 0) { ?>
                            <div class="admin-pagination">
                                <?php echo $pagination['view']; ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-end">
                        <select name="limit" class="w-auto mr-2 form-control form-control-solid form-control-sm page-limit">
                            <option value="20">20</option>
                            <option value="50" {{ isset($_GET['limit']) && $_GET['limit'] == 50 ? 'selected' : '' }}>50</option>
                            <option value="70" {{ isset($_GET['limit']) && $_GET['limit'] == 70 ? 'selected' : '' }}>70</option>
                            <option value="100" {{ isset($_GET['limit']) && $_GET['limit'] == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                            <?php if($total != 0) { ?>
                                Showing {{ $pagination['showing_from'] }}
                                to {{ $pagination['showing_to'] }}
                                of
                            <?php } ?>
                            {{ $total }} entries
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
