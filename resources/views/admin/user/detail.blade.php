@extends('admin::layouts.admin_template')
@section('content')
<p><a title="Main Module" href="{{ route('getManageUser') }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Manage Customer</a></p>
<style type="text/css">
    .img-thumb{
        height: 240px;
        width: 240px;
        border: 1px solid grey;
        padding: 10px;
        margin: 10px;
    }
</style>
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
                                        <td>Name</td>
                                        <td>{{ $row->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                       <td><a href="mailto:{{$row->email}}">{{$row->email}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Number</td>
                                       <td><a href="tel:{{$row->c_code.$row->phone_number}}">{{$row->phone_number}}</a></td>
                                    </tr>                                 
                                    <tr>
                                        <td>Country</td>
                                        <td>{{ $row->country->country_name }}</td>
                                    </tr> 
                                    <tr>
                                        <td>City</td>
                                        <td>{{ $row->city->city_name }}</td>
                                    </tr>    
                                    <tr>
                                        <td>Company</td>
                                        <td>{{ $row->company->company_name }}</td>
                                    </tr>                              
                                    <tr>
                                        <td>Status</td>
                                        <td>{{ ($row->status==1)?'Active':'Inactive' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Created At</td>
                                        <td>{{ $row->created_at }}</td>
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