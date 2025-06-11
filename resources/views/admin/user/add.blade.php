@extends('admin::layouts.admin_template')
@section('content')
<p><a title="Main Module" href="{{ route('getManageUser') }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Manage Customers</a></p>

<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-header card-primary align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
                <div class="flex-shrink-0">
                </div>
            </div> 

            <div class="card-body">
            <form action="{{ route('postAddUser') }}" method="post" enctype="multipart/form-data" autocomplete="off"> 
            	@csrf
            	<input type="hidden" name="return_url" value="{{ route('getManageUser') }}">
            	<div class="row">
            		<div class="col-md-12">
                        <div class="mb-3 ">
                            <label for="name" class="form-label"> Name <span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" title="Name" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter Name" required>                          
                            @error('name')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 ">
                            <label for="email" class="form-label">Email <span class="text-danger" title="This field is required">*</span></label>
                            <input type="email" title="Email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter Email" required>                          
                            @error('email')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 ">
                            <label for="phone_number" class="form-label">Contact Number <span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" title="Phone Number" class="form-control onlyNumberKey" name="phone_number" id="phone_number" maxlength="10" value="{{ old('phone_number') }}" placeholder="Enter Phone Number" required>                          
                            @error('phone_number')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 ">
                            <label for="country_id" class="form-label">Country <span class="text-danger" title="This field is required">*</span></label>
                            <select name="country_id" class="form-control" required>
                                <option value="">Select Country</option>
                                @if(!empty($countries))
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                                @endif
                            </select>                          
                            @error('country_id')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 ">
                            <label for="city_id" class="form-label">City <span class="text-danger" title="This field is required">*</span></label>
                            <select name="city_id" class="form-control" required>
                                <option value="">Select City</option>
                            </select>                          
                            @error('city_id')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 ">
                            <label for="company_id" class="form-label">Company <span class="text-danger" title="This field is required">*</span></label>
                            <select name="company_id" class="form-control" required>
                                <option value="">Select Company</option>
                            </select>                          
                            @error('company_id')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 ">
                            <label for="password" class="form-label"> Password <span class="text-danger" title="This field is required"></span></label>
                            <input type="password" title="Password" class="form-control" name="password" id="password" maxlength="13" value="" placeholder="Enter password">                          
                            @error('password')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
                    <div class="col-md-12">
                        <div class="mb-6 ">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <p class="text-muted"></p>
                        </div>                      
                    </div>
            	</div>
            	<div class="row g-3">
                        <div class="form-group">
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-10">
                            	<a href="{{ route('getManageUser') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>
                                <input type="submit" name="submit" value="Save & Add More" class="btn btn-primary">
                            	<input type="submit" name="submit" value="Save" class="btn btn-primary">                                
                            </div>
                        </div>
                    </div>
            	</form>
            </div>
		</div>
	</div>
</div>
@endsection

@push('bottom')
<script type="text/javascript">
    var country_id = '';
    $(document).ready( function(){
        $("select[name='country_id']").on('change', function(){
            country_id = $(this).val();
            if(country_id>0)
            {
                var options='<option value="">Loading...</option>';
                $("select[name='city_id']").html(options);
                $.get("{{url('ajax/get-cities/')}}/"+country_id, function(resp){
                    options='<option value="">Select City</option>';
                    if(resp.length>0)
                    {                    
                        $.each(resp, function(index, item) {                            
                            options+=`<option value="${item.id}">${item.city_name}</option>`;
                        });                    
                    }

                    $("select[name='city_id']").html(options);
                })
            }else{
                $("select[name='city_id']").html('<option value="">Select City</option>');
            }            
        })

        $("select[name='city_id']").on('change', function(){
            var city_id = $(this).val();
            if(city_id>0)
            {
                var options='<option value="">Loading...</option>';
                $("select[name='company_id']").html(options);
                $.get("{{url('ajax/get-companies/')}}/"+country_id+'/'+city_id, function(resp){
                    options='<option value="">Select Company</option>';
                    if(resp.length>0)
                    {                    
                        $.each(resp, function(index, item) {                            
                            options+=`<option value="${item.id}">${item.company_name}</option>`;
                        });                    
                    }

                    $("select[name='company_id']").html(options);
                })
            }else{
                $("select[name='company_id']").html('<option value="">Select Company</option>');
            }            
        })
    })
</script>
@endpush