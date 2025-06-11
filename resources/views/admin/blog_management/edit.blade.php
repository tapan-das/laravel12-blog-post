@extends('admin::layouts.admin_template')
@section('content')
<script type="text/javascript" src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<p><a title="Main Module" href="{{ route('getManageBlog') }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Manage Blog</a></p>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-primary align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">{{ $page_title }}</h4>
				<div class="flex-shrink-0">
				</div>
			</div>

			<div class="card-body">
				<form action="{{ route('postUpdateBlog', $row->id) }}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="return_url" value="{{ route('getManageBlog') }}">
					<div class="row">


						<div class="col-md-6">
							<div class="mb-3 ">
								<label class="form-label">Page Title <span class="text-danger" title="This field is required"></span></label>
								<input type="text" title="Page Title" class="form-control" name="page_title" value="{{ (old('page_title'))?old('page_title'):$row->page_title }}" placeholder="Page Title" required readonly>
								@error('page_title')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="label-setting">Featured Image</label>
								@if(!empty($row->featured_image) && (Storage::exists($row->featured_image) || file_exists(public_path($row->featured_image))))
								<div class="prev-img-thumb"><img src="{{ asset($row->featured_image) }}"></div>
								<p class="text-muted"><em>* If you want to upload other image, please first delete the image.</em></p>
								<p><a class="btn btn-danger btn-primary btn-sm" href="{{AdminHelper::adminpath()}}/download-file?image={{$row->featured_image}}"><i class="fa fa-download"></i> Download </a>
									<a class="btn btn-danger btn-delete btn-sm" onclick="if(!confirm('Are you sure ?')) return false" href="{{AdminHelper::adminpath()}}/delete-image?image={{$row->featured_image}}&&id={{$row->id}}&&column=featured_image&table=blog_pages"><i class="fa fa-ban"></i> Delete </a>
								</p>
								@else
								<input type="file" name="image" id="image" accept="image/*" class="form-control">
								<div class="text-muted">The image should be JPG/JPEG/PNG/GIF/SVG type and the image size should not above 2MB.</div>
								@error('image')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								@endif
							</div>
						</div>

						<div class="col-md-12">
							<div class="mb-3 ">
								<label class="form-label">Page Content <span class="text-danger" title="This field is required">*</span></label>
								<textarea name="page_content" class="form-control" id="description">
								{{ (old('page_content'))?old('page_content'):$row->page_content }}

								</textarea>
								@error('page_content')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3 ">
								<label class="form-label">Meta Title <span class="text-danger" title="This field is required">*</span></label>
								<input type="text" title="Meta Title" class="form-control" name="meta_title" value="{{ (old('meta_title'))?old('meta_title'):$row->meta_title }}" placeholder="Meta Title" required>
								@error('meta_title')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3 ">
								<label class="form-label">Meta Keywords</label>
								<input type="text" title="Meta Keywords" class="form-control" name="meta_keywords" value="{{ (old('meta_keywords'))?old('meta_keywords'):$row->meta_keywords }}">
								@error('meta_keywords')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3 ">
								<label class="form-label">Meta Description</label>
								<textarea name="meta_description" class="form-control" rows="3">{{ (old('meta_description'))?old('meta_description'):$row->meta_description }}</textarea>
								@error('meta_description')
								<div class="text-danger mt-1" role="alert">
									<strong>{{ $message }}</strong>
								</div>
								@enderror
								<p class="text-muted"></p>
							</div>
						</div>

						<input type="hidden" name="status" value="1">

					</div>
					<div class="row g-3">
						<div class="form-group">
							<label class="control-label col-sm-2"></label>
							<div class="col-sm-10">
								<a href="{{ route('getManageBlog') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>
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
		CKEDITOR.replace('description', {
			allowedContent: true,
			versionCheck: false
		});
	});
</script>
@endpush