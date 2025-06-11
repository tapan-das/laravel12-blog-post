@extends('admin::layouts.admin_template')
@section('content')
<!-- <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script> -->
<script type="text/javascript" src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>

<p><a title="Main Module" href="{{ route('getManageBanner') }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Manage Banner</a></p>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-primary align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
                <div class="flex-shrink-0">
                </div>
            </div> 



            <div class="card-body">
            	<form action="{{ route('postUpdateBanner', $row->id) }}" method="post" enctype="multipart/form-data">
            	@csrf
            	<input type="hidden" name="return_url" value="{{ route('getManageBanner') }}">
            	<div class="row">
						<div class="col-md-6">
							<div class="mb-3 ">
								<label for="title" class="form-label">Title <span class="text-danger" title="This field is required">*</span></label>
								<input type="text" title="name" class="form-control" name="title" id="title" value="{{ (!empty(old('title'))?old('title'):$row->title) }}" placeholder="Enter Image Name" required>
								@error('title')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3 ">
								<label for="title" class="form-label">Banner Order <span class="text-danger" title="This field is required">*</span></label>
								<input type="text" title="name" class="form-control" name="order" id="order" value="{{ (!empty(old('order'))?old('order'):$row->order) }}" placeholder="Enter Sliding Order" required>
								@error('order')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3 ">
								<label for="title" class="form-label">Banner Image</label>
								
								<input type="file" class="form-control" name="banner_image" id="banner_image" value="{{ $row->image }}" accept="image/*">
								@if(!empty($row->image))
								<div class="mt-2" id="image-preview-container">
								<img src="{{ asset($row->image) }}" alt="Existing Image" id="existing-image" height="50" width="50">
									<button type="button" class="btn btn-danger mt-2" id="remove-bkgrd-img">Remove</button>
								</div>
								@endif
								@error('banner_image')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<input type="hidden" name="existing_banner_path" value="{{ $row->image }}">
								<p class="text-muted">The image should be JPG/JPEG/PNG/GIF/SVG type and the image size should not above 2MB.</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3 ">
								<label for="Nameinput" class="form-label">Select Status<span class="text-danger" title="This field is required">*</span></label>
								<select class="form-control" name="status" required>
									<option value="">Select Status</option>
									<option value="1" @if($row->status==1) selected @endif >Active</option>
									<option value="0" @if($row->status==0) selected @endif >Inactive</option>
								</select>
								@error('status')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3 ">
								<label for="title" class="form-label">Description <span class="text-danger" title="This field is required">*</span></label>
								<textarea title="name" class="form-control" name="description" id="description" placeholder="Enter Image Description"> {{ (!empty(old('description'))?old('description'):$row->description) }}</textarea>
								@error('description')
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
                            	<a href="{{ route('getManageBanner') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>
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

	$(document).ready(function() {
		CKEDITOR.replace( 'description',{
	  	allowedContent : true,
	  	versionCheck: false
	});
		document.getElementById('remove-bkgrd-img')?.addEventListener('click', function() {
			document.getElementById('image-preview-container').style.display = 'none';
			document.getElementById('banner_image').style.display = 'block';
			document.querySelector('input[name="existing_banner_path"]').value = '';
		});
	});
</script>
@endpush