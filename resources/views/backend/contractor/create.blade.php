@extends('layouts.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Create New Contractor</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('leads')}}">Contractor</a></li>
			<li class="breadcrumb-item active">Create new Contractor</li>
		</ul>
	</div>	
</div>
@endsection


@section('content')
<form method="POST" action="{{route('contractor.add')}}" enctype="multipart/form-data">

					@csrf

					<div class="row">

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">First Name <span class="text-danger">*</span></label>

								<input class="form-control" name="first_name" type="text" value="{{ old('first_name') }}">

							</div>

						</div>

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Last Name</label>

								<input class="form-control" name="last_name" type="text" value="{{ old('last_name') }}">

							</div>

						</div>

						

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Email <span class="text-danger">*</span></label>

								<input class="form-control" name="email" type="email" value="{{ old('email') }}">

							</div>

						</div>

						

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Phone </label>

								<input class="form-control" name="phone_number" type="text" value="{{ old('phone_number') }}">

							</div>

						</div>

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Company Name</label>

								<input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<label>Company Address <span class="text-danger">*</span></label>

								<input type="text" class="form-control" name="company_address" value="{{ old('company_address') }}">

							</div>

						</div>

						<div class="col-md-3">

							<div class="form-group">

								<label>Company Website <span class="text-danger">*</span></label>

								<input type="text" class="form-control" name="company_website" value="{{ old('company_website') }}">

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label>License Number <span class="text-danger">*</span></label>

								<input type="text" class="form-control" name="company_lic_num" value="{{ old('company_lic_num') }}">

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label class="">Budget<span class="text-danger">*</span></label>

								<input class="form-control floating" name="budget" type="text" value="{{ old('budget') }}">

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label class="">Location(Zip)<span class="text-danger">*</span></label>

								<input class="form-control floating" name="location" type="text" value="{{ old('location') }}">

							</div>

						</div>

                        <div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">License Image<span class="text-danger">*</span></label>
								<input class="form-control floating" name="license_img" type="file">
							</div>
						</div>

                        <div class="col-md-12">

							<div class="form-group">

								<label class="col-form-label">Services<span class="text-danger">*</span></label><br>

                                @foreach (config('const.services') as $service)

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" value="{{ $service }}" id="electricalCheck" name="services[]"  >

                                    <label class="form-check-label" for="electricalCheck">

                                      {{ $service }}

                                    </label>

                                  </div> 

                                  @endforeach

							</div>

						</div>

					</div>



                    

					

					<div class="submit-section">

						<button class="btn btn-primary submit-btn">Submit</button>

					</div>

				</form>
               

@endsection


@section('scripts')
<!-- Summernote JS -->
<script src="{{asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>

@endsection