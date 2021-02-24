@extends('admin.layout.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom mb-8">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        Filter {{ $meta['heading'] }}    
                    </h3>
                </div>
            </div>

            <div class="card-body">
                <form class="row">
                    <div class="col-4">
                        <input type="text" />
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="row bx-bulk-action w-100 align-items-center">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_length" id="dataTable_length">
                            <label class="m-0">
                                <select id="bulk-action-select" name="bulk_action" class="m-0 custom-select custom-select-sm form-control form-control-sm">
                                    <option value="">Bulk Edit Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                    <option value="-1">Delete Permanent</option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Export
                            </button>

                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <ul class="navi flex-column navi-hover py-2">
                                    <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                        Choose an option:
                                    </li>
                                    <?php /*<li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-print"></i>
                                            </span>
                                            <span class="navi-text">Print</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-copy"></i>
                                            </span>
                                            <span class="navi-text">Copy</span>
                                        </a>
                                    </li>*/ ?>
                                    <li class="navi-item">
                                        <a id="export-excel" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-excel-o"></i>
                                            </span>
                                            <span class="navi-text">Excel</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a id="export-csv" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-text-o"></i>
                                            </span>
                                            <span class="navi-text">CSV</span>
                                        </a>
                                    </li>
                                    <?php /*<li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-pdf-o"></i>
                                            </span>
                                            <span class="navi-text">PDF</span>
                                        </a>
                                    </li>*/ ?>
                                </ul>
                            </div>
                        </div>

                        <a href="{{ url(admin_uri().'pages/create') }}" class="btn btn-primary font-weight-bolder">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                    width="24px" height="24px" 
                                    viewBox="0 0 24 24" version="1.1"
                                >
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                            </span>
                            Add 
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-12 col-md-5 d-flex align-items-center">
                        <select id="page-limit" name="limit" class="w-auto mr-2 custom-select custom-select-sm form-control form-control-sm">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="70">70</option>
                            <option value="100">100</option>
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

                    <?php if($total != 0) { ?>
                        <div class="col-sm-12 col-md-7">
                            <div class="admin-pagination">
                                <?php echo $pagination['view']; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <form id="table-data" class="table-responsive">
                    <table id="{{ $table }}" class="table table-vertical-center table-head-custom table-foot-custom table-checkable table-list">
                        <thead>
                            <tr>
                                @if( Auth::guard('admin')->user()->role_id == 1)
                                    <th class="select-all select_all">
                                        <label class="checkbox checkbox-lg checkbox-inline">
                                            <input id="bulk-action-checkbox" type="checkbox" class="bulk_action_select">
                                            <span></span>
                                        </label>
                                    </th>
                                @endif
                                <?php foreach($table_head as $khead => $vhead) { ?>
                                    <th class="{{ $khead }} {{ ( (isset($_GET['order']) && $_GET['order'] === $khead) ) ? "active" : "" }} {{ $vhead['class'] }}">
                                        <a <?php echo (!empty($vhead['order'])) ? 'href="' . $pagination['base_sort_link'] . $vhead['order'] . '"' : ''; ?>>
                                            {{  ucwords( str_replace("_", " ", $khead) ) }} <?php echo (!empty($vhead['order'])) ? "<span></span>" : ''; ?>
                                        </a>
                                    </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                @if( Auth::guard('admin')->user()->role_id == 1)
                                    <th class="select-all select_all">
                                        <label class="checkbox checkbox-lg checkbox-inline">
                                            <input id="bulk-action-checkbox-footer" type="checkbox" class="bulk_action_select">
                                            <span></span>
                                        </label>
                                    </th>
                                @endif
                                <?php foreach($table_head as $khead => $vhead) { ?>
                                    <th class="{{ $khead }} {{ ( (isset($_GET['order']) && $_GET['order'] === $khead) ) ? "active" : "" }} {{ $vhead['class'] }}">
                                        <a <?php echo (!empty($vhead['order'])) ? 'href="' . $pagination['base_sort_link'] . $vhead['order'] . '"' : ''; ?>>
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
                                        @if( Auth::guard('admin')->user()->role_id === 1)
                                            <td>
                                                <label class="checkbox checkbox-lg checkbox-inline">
                                                    <input type="checkbox" value="{{ $dt['uuid'] }}" name="bulk[]" class="bulk_action_list">
                                                    <span></span>
                                                </label>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ admin_uri() . $dt['uuid'] }}">
                                                {{ $dt['name'] }}
                                            </a>
                                        </td>
                                        <td>
                                            <img src="{{ $dt['featured_image'] ? asset('/img/'.$dt['featured_image']) : asset('/img/admin/layout/no-image-available.png') }}"
                                                alt="{{ $dt['name'] }}"
                                                width="80"
                                            />
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
                                    <td colspan="{{ Auth::guard('admin')->user()->role_id === 1 || Auth::guard('admin')->user()->role_id === 2 ? 6 : 5 }}" style="text-align:center;">
                                        No Data
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>

                <div class="row align-items-center mt-3">
                    <div class="col-sm-12 col-md-5 d-flex align-items-center">
                        <select id="page-limit" name="limit" class="w-auto mr-2 custom-select custom-select-sm form-control form-control-sm">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="70">70</option>
                            <option value="100">100</option>
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

                    <?php if($total != 0) { ?>
                        <div class="col-sm-12 col-md-7">
                            <div class="admin-pagination">
                                <?php echo $pagination['view']; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection