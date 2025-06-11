@extends('admin::layouts.admin_template')
@section('content')

<div class="list-grid-nav hstack gap-1 mb-3">
    <div class="selected-action" style="display:inline-block;position:relative;">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                class="fa fa-check-square-o"></i> Bulk Actions</button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="javascript:void(0)" data-name="active" title="Active Selected"><i
                        class="fa fa-check"></i> Active Selected</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)" data-name="inactive" title="Inactive Selected"><i
                        class="fa fa-times"></i> Inactive Selected</a></li>
            <li><a class="dropdown-item text-danger" href="javascript:void(0)" data-name="delete" title="Delete Selected"><i
                        class="fa fa-trash"></i> Delete Selected</a></li>
        </ul>
    </div>
    
    <a href="{{ route('getAddUser') }}?return_url={{ route('getManageUser') }}"
        id="btn_add_new_data" class="btn btn-primary" title="Add Data">
        <i class="fa fa-plus-circle"></i> Add Data
    </a>
   
</div>



<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
        <div class="box-tools pull-right" style="position: relative;margin-top: -5px;margin-right: -10px">   

            <form method="get" style="display:inline-block;width: 290px;"
                action="{{ route('getManageUser') }}">
                <div class="input-group">
                    <input type="text" name="q" value="{{ request()->get('q') }}" class="form-control rounded-0 pull-right" placeholder="Search">

                    <div class="input-group-btn">
                        @if(!empty(request()->get('q')))
                        <button type="button" onclick="location.href='{{ route('getManageUser') }}'" title="Reset" class="btn rounded-0 btn-warning"><i class="fa fa-ban"></i></button>
                        @endif
                        <button type="submit" class="btn rounded-0 btn-primary me-2"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>


            <form method="get" id="form-limit-paging" style="display:inline-block"
                action="{{ route('getManageUser') }}">
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
            <form id="form-table" method="post" action="{{ route('getManageUser') }}/action-selected">
                <input type='hidden' name='button_name' value=''/>
                @csrf                
                <table id="table_dashboard" class="table align-middle table-nowrap table-hover mb-0">
                    <thead class="table-blue">
                        <tr class="active">
                            <th width="3%"><input type="checkbox" id="checkall"></th>
                            <th width="auto"><a href="{{ route('getManageUser') }}?filter_column=name&sorting={{(request()->get('filter_column')=='name' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort">Name &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th width="auto"><a href="{{ route('getManageUser') }}?filter_column=email&sorting={{(request()->get('filter_column')=='email' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort">Email &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th width="auto"><a href="{{ route('getManageUser') }}?filter_column=phone_number&sorting={{(request()->get('filter_column')=='phone_number' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort">Contact Number &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th width="auto"><a href="{{ route('getManageUser') }}?filter_column=status&sorting={{(request()->get('filter_column')=='status' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort">Status &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th width="auto"><a href="{{ route('getManageUser') }}?filter_column=created_at&sorting={{(request()->get('filter_column')=='created_at' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort">Created At &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th width="auto" style="text-align:right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($rows) && count($rows))
                        @foreach($rows as $data)
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="checkbox[]" value="{{$data->id}}"></td>
                            <td>{{ $data->name }}</td>                            
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->phone_number }}</td>
                            <td>@if($data->status==1) <span class="badge bg-success">Approved</span> @elseif($data->status==2) <span class="badge bg-danger">Rejected</span> @else <span class="badge bg-warning">Pending</span>  @endif</td>
                            <td>{{ date('m-d-Y', strtotime($data->created_at)) }}</td>
                            <td>
                                <div class="button_action" style="text-align:right">
                                    <!-- @if($data->status==0)
                                    <a class="btn btn-sm btn-success btn-detail" title="Approve Profile" href="{{ route('updateProfileStatus', [$data->id, 1]) }}?return_url={{ route('getManageUser') }}">Approve</a>
                                    <a class="btn btn-sm btn-danger btn-detail" title="Approve Profile" href="{{ route('updateProfileStatus', [$data->id, 2]) }}?return_url={{ route('getManageUser') }}">Reject</a>
                                    @endif -->

                                <a class="btn btn-sm btn-primary btn-detail" title="Detail Data" href="{{ route('getDetailUser', $data->id) }}?return_url={{ route('getManageUser') }}"><i class="fa fa-eye"></i></a>
                                
                                
                                <a class="btn btn-sm btn-success btn-edit" title="Edit Data" href="{{ route('getEditUser', $data->id) }}?return_url={{ route('getManageUser') }}"><i class="fa fa-pencil"></i></a>
                                          

                                
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
                                    t.isConfirmed?location.href='{{ route('deleteUser', $data->id) }}':''});">
                                    <i class="fa fa-trash"></i>
                                </a>
                                

                                </div>
                            </td>
                        </tr>                        
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" style="text-align:center"><i class="fa fa-search"></i> No Data Avaliable</td>
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
            <div class="col-md-8"> <div class="pull-right">{!! $rows->withQueryString()->links('pagination::bootstrap-4') !!} </div></div>         
        </div>
    </div>


</div>
@endsection