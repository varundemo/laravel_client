@extends('layouts.backend')

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Contractors</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
			<li class="breadcrumb-item active">Contractors</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
		<div class="view-icons">
			<a href="{{route('contractors')}}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
			<a href="{{route('contractors-list')}}" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
		</div>
	</div>
</div>
@endsection

@section('content')

<!-- Add Employee Modal -->
<div id="add_employee" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-headere">
				<h5 class="modal-title">Add Contractor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">e&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{{-- <form method="POST" action="{{route('employee.add')}}" enctype="multipart/form-data"> --}}
				<form method="POST" action="{{route('contractor.add')}}" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">First Name <span class="text-danger">*</span></label>
								<input class="form-control" name="first_name" type="text" value="{{ old('first_name') }}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Last Name</label>
								<input class="form-control" name="last_name" type="text" value="{{ old('last_name') }}">
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Email <span class="text-danger">*</span></label>
								<input class="form-control" name="email" type="email" value="{{ old('email') }}">
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Phone </label>
								<input class="form-control" name="phone_number" type="text" value="{{ old('phone_number') }}">
							</div>
						</div>
						<div class="col-sm-6">
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
						<div class="col-md-6">
							<div class="form-group">
								<label>Company Website <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="company_website" value="{{ old('company_website') }}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>License Number <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="company_lic_num" value="{{ old('company_lic_num') }}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Budget<span class="text-danger">*</span></label>
								<input class="form-control floating" name="budget" type="text" value="{{ old('budget') }}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Location(Zip)<span class="text-danger">*</span></label>
								<input class="form-control floating" name="location" type="text" value="{{ old('location') }}">
							</div>
						</div>
                        <div class="col-md-6">
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
			</div>
		</div>
	</div>
</div>
<!-- /Add Employee Modal -->

@endsection