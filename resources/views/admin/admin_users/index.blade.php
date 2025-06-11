@extends('admin::layouts.admin_template')
@section('content')

<div class="list-grid-nav hstack gap-1 mb-3">


    <a href="{{ route('getAddAdminUser') }}?return_url={{ route('getAdminUsers') }}"
        id="btn_add_new_data" class="btn btn-primary" title="Add Data">
        <i class="fa fa-plus-circle"></i> Add Data
    </a>

</div>



<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
        <div class="box-tools pull-right" style="position: relative;margin-top: -5px;margin-right: -10px">   

            <form method="get" style="display:inline-block;width: 290px;"
                action="{{ route('getAdminUsers') }}">
                <div class="input-group">
                    <input type="text" name="q" value="{{ request()->get('q') }}" class="form-control rounded-0 pull-right" placeholder="Search">

                    <div class="input-group-btn">
                        @if(!empty(request()->get('q')))
                        <button type="button" onclick="location.href='{{ route('getAdminUsers') }}'" title="Reset" class="btn rounded-0 btn-warning"><i class="fa fa-ban"></i></button>
                        @endif
                        <button type="submit" class="btn rounded-0 btn-primary me-2"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>


            <form method="get" id="form-limit-paging" style="display:inline-block"
                action="{{ route('getAdminUsers') }}">
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
            <form id="form-table" method="post" action="{{ route('getAdminUsers') }}/action-selected">
                <input type='hidden' name='button_name' value=''/>
                @csrf                
                <table id="table_dashboard" class="table align-middle table-nowrap table-hover mb-0">
                    <thead class="table-blue">
                        <tr class="active">
                            <th width="3%"><input type="checkbox" id="checkall"></th>
                            <th><a href="{{ route('getAdminUsers') }}?filter_column=name&sorting={{(request()->get('filter_column')=='name' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort ascending">Name &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th><a href="{{ route('getAdminUsers') }}?filter_column=email&sorting={{(request()->get('filter_column')=='email' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort ascending">Email &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th><a href="{{ route('getAdminUsers') }}?filter_column=id_admin_privileges&sorting={{(request()->get('filter_column')=='id_admin_privileges' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort ascending">Privilege &nbsp; <i class="fa fa-sort"></i></a></th>
                            <th><a href="{{ route('getAdminUsers') }}?filter_column=status&sorting={{(request()->get('filter_column')=='status' && request()->get('sorting')=='asc')?'desc':'asc'}}" title="Click to sort ascending">Status &nbsp; <i class="fa fa-sort"></i></a></th>
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
                            <td>{{ (!empty($data->privilege)?$data->privilege->name:'') }}</td>         
                            <td>@if($data->status==1) <span class="badge bg-success">Active</span> @elseif($data->status==0) <span class="badge bg-warning">Inactive</span>  @endif</td>                  
                            <td>
                                <div class="button_action" style="text-align:right">                               
                                <a class="btn btn-sm btn-success btn-edit" title="Edit Data" href="{{ route('getEditAdminUser', $data->id) }}?return_url={{ route('getAdminUsers') }}"><i class="fa fa-pencil"></i></a>
                             
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
                                    t.isConfirmed?location.href='{{ AdminHelper::adminpath() }}/admin-users/delete/{{$data->id}}':'' });">
                                    <i class="fa fa-trash"></i>
                                </a>
                                

                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" style="text-align:center"><i class="fa fa-search"></i> No Data Avaliable</td>
                        </tr>
                        @endif                        
                    </tbody>
                </table>

            </form>

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