@extends('admin::layouts.admin_template')
@section('content')

<!-- <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script> -->
<script type="text/javascript" src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>

<p><a title="Main Module" href="{{ AdminHelper::adminpath() }}/manage-banner"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Manage Banner</a></p>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-primary align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
                <div class="flex-shrink-0">
                </div>
            </div> 

            <div class="card-body">
            	<form action="{{ route('postAddBanner') }}" method="post" enctype="multipart/form-data">
            	@csrf
            	<input type="hidden" name="return_url" value="{{ route('getManageBanner') }}">
            	<div class="row">
            		<div class="col-md-6">
						<div class="mb-3 ">
                                <label for="title" class="form-label">Title <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" title="name" class="form-control" name="title" id="title" value="{{ old('title') }}" placeholder="Enter Title" required>
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
                                <input type="text" title="name" class="form-control integer-validate" name="order" id="order" value="{{ old('order') }}" placeholder="Enter Banner Order" required>
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
                                <label for="title" class="form-label">Banner Image <span class="text-danger" title="This field is required">*</span></label>
                                <input type="file" title="image" class="form-control" name="image" id="image" accept="image/*" required>
                                @error('image')
                                <div class="text-danger mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                                <p class="text-muted">The image should be JPG/JPEG/PNG/GIF/SVG type and the image size should not above 2MB.</p>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="mb-3 ">
                                <label for="Nameinput" class="form-label">Select Status<span class="text-danger" title="This field is required">*</span></label>
                                <select class="form-control" name="status" required>
                                    <option value="">Select Status</option>
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
						<div class="col-md-12">
                            <div class="mb-3 ">
                                <label for="title" class="form-label">Description <span class="text-danger" title="This field is required">*</span></label>
                                <textarea title="name" class="form-control" name="description" id="description" placeholder="Enter Image Description" rows="3" required> {{ old('description') }}</textarea>
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

<script>
	$(document).ready(function() {
			CKEDITOR.replace( 'description',{
			allowedContent : true,
			versionCheck: false
		});
	});
$('.integer-validate').on('keypress', function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;

                // Get current value length
                var currentLength = $(this).val().length;

                // Allow only numbers (48-57) and backspace (8), and limit to 8 digits
                if (currentLength >= 8 && charCode !== 8) {
                    e.preventDefault(); // Prevent more than 8 digits
                } else if (charCode < 48 || charCode > 57) {
                    if (charCode !== 8) {
                        e.preventDefault(); // Prevent non-numeric input
                    }
                }
            });

            // Prevent pasting non-numeric or more than 8 digits content
            $('.integer-validate').on('paste', function(e) {
                var clipboardData = e.originalEvent.clipboardData.getData('Text');
                var currentLength = $(this).val().length;

                // Check if pasted data is numeric and doesn't exceed 8 digits in total
                if (!/^\d+$/.test(clipboardData) || (clipboardData.length + currentLength) > 8) {
                    e.preventDefault();
                }
            });
</script>
@endpush