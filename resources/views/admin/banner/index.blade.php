@extends('admin::layouts.admin_template')
@section('content')

<div class="list-grid-nav hstack gap-1 mb-3">
    <div class="selected-action" style="display:inline-block;position:relative;">

    </div>

    <a href="{{ route('getAddBanner') }}?return_url={{ route('getManageBanner') }}"
        id="btn_add_new_data" class="btn btn-primary" title="Add Data">
        <i class="fa fa-plus-circle"></i> Add Data
    </a>

</div>
<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
        <div class="box-tools pull-right" style="position: relative;margin-top: -5px;margin-right: -10px">

            <form method="get" style="display:inline-block;width: 290px;"
                action="{{ route('getManageBanner') }}">
                <div class="input-group">
                    <input type="text" name="q" value="{{ request()->get('q') }}" class="form-control rounded-0 pull-right" placeholder="Search">

                    <div class="input-group-btn">
                        @if(!empty(request()->get('q')))
                        <button type="button" onclick="location.href='{{ route('getManageBanner') }}'" title="Reset" class="btn rounded-0 btn-warning"><i class="fa fa-ban"></i></button>
                        @endif
                        <button type="submit" class="btn rounded-0 btn-primary me-2"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>


            <form method="get" id="form-limit-paging" style="display:inline-block"
                action="{{ route('getManageBanner') }}">
                @php $limis =[5,10,20,25,50,100,200]; @endphp
                <div class="input-group">
                    <select onchange="$('#form-limit-paging').submit()" name="limit" style="width: 56px;"
                        class="form-control input-sm">
                        @foreach($limis as $lmt)
                        <option value="{{ $lmt }}" {{ ($lmt==$limit)?'selected':'' }}>{{$lmt}}</option>
                        @endforeach
                    </select>
                </div>
            </form>

        </div>

        <br style="clear:both">

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form id="form-table" method="post" action="{{ route('getManageBanner') }}/action-selected">
                <input type='hidden' name='button_name' value='' />
                @csrf
                <table id="table_dashboard" class="table align-middle table-nowrap table-hover mb-0">
                    <thead class="table-blue">
                        <tr class="active">
                            <th width="3%"><input type="checkbox" id="checkall"></th>
                            <th width="auto"><a href="{{ route('getManageBanner') }}?filter_column=title&sorting={{(request()->get('filter_column')=='title' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort ascending">Title &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th width="auto">Image</th>
                            <th width="auto">Description</th>
                            <th width="auto">Banner Order</th>
                            <th width="auto">Status</th>
                            <th width="auto" style="text-align:right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($rows) && count($rows))
                        @foreach($rows as $data)
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="checkbox[]" value="{{$data->id}}"></td>
                            <td>{{ $data->title }}</td>
                            <td>
                                @if(!empty($data->image))
                                <img src="{{ URL::to('/').'/'.$data->image }}" alt="Banner Image" height="50px" width="50px" />
                                @else
                                No Image
                                @endif
                            </td>
                            <td>{!! $data->description !!}</td>
                            <td>{{ $data->order }}</td>
                            <td>@if($data->status==1) <span class="badge bg-success">Active</span> @elseif($data->status==0) <span class="badge bg-warning">Inactive</span> @endif</td>
                            {{--<td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y h:i A') }}</td>
                            <td>{{ $data->creator->name ?? 'Unknown' }}</td> --}}
                            <td>
                                <div class="button_action" style="text-align:right">
                                    @if(AdminHelper::isRead())
                                    <a class="btn btn-sm btn-primary btn-detail" title="Detail Data" href="{{ route('getDetailBanner', $data->id) }}?return_url={{ route('getManageBanner') }}"><i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(AdminHelper::isUpdate())
                                    <a class="btn btn-sm btn-success btn-edit" title="Edit Data" href="{{ route('getEditBanner', $data->id) }}?return_url={{ route('getManageBanner') }}"><i class="fa fa-pencil"></i></a>
                                    @endif

                                    @if(AdminHelper::isDelete())
                                    <a class="btn btn-sm btn-warning btn-delete" title="Delete" href="javascript:;" onclick="Swal.fire({
                                    title: 'Are you sure ?',   
                                    text: 'You will not be able to recover this record data!',  
                                    icon: 'warning',
                                    showCancelButton: !0,
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'No, cancel!',
                                    confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                                    cancelButtonClass: 'btn btn-danger w-xs mt-2',
                                    buttonsStyling: !1,
                                    showCloseButton: !0,
                                }).then(function (t) {
                                    t.isConfirmed?location.href='{{ route('deleteBanner', $data->id) }}':'' });">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" style="text-align:center"><i class="fa fa-search"></i> No Data Avaliable</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

            </form>
            <!--END FORM TABLE-->
            <!-- <div class="col-md-4"><span class="pull-right">Total rows
                    : 1 to 3 of 3</span></div> -->

        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <span>Total rows : {{ $rows->total() }}</span>
            </div>
            <div class="col-md-8">
                <div class="pull-right">{!! $rows->withQueryString()->links('pagination::bootstrap-4') !!} </div>
            </div>
        </div>
    </div>


</div>

@endsection