@extends('admin::layouts.admin_template')
@section('content')
<p><a title="Main Module" href="{{ url()->previous() }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Manage Banners</a></p>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-primary align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
                <div class="flex-shrink-0">
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="table-responsive">
                        <table id="table-detail" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Title</td>
                                    <td>{{ $row->title }}</td>
                                </tr>
                                <tr>
                                    <td>Banner Order</td>
                                    <td>{{ $row->order }}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{!! $row->description !!}</td>
                                </tr>
                                <tr>
                                    <td>Banner Image</td>
                                    <td>
                                        @if(!empty($row->image))
                                        <img src="{{ URL::to('/').'/'.$row->image }}" alt="Banner Image" height="50px" width="50px" />
                                        @else
                                        No Image
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>@if($row->status==1) <span class="badge bg-success">Active</span>@else<span class="badge bg-danger">Inactive</span>@endif</td>
                                </tr>
                                <tr>
                                    <td>Created At</td>
                                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('M d, Y h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->

                </form>

            </div>
        </div>
    </div>
    <!--END AUTO MARGIN-->

</div>
@endsection