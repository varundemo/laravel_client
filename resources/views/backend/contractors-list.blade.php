@extends('layouts.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">

<!-- Summernote CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/dist/summernote-bs4.css')}}">
@endsection

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

		<a href="{{route('contractor-create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Contractor</a>

		<div class="view-icons">

			{{-- <a href="{{route('contractors')}}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a> --}}

			{{-- <a href="{{route('contractors-list')}}" class="list-view btn btn-link"><i class="fa fa-bars"></i></a> --}}

		</div>

	</div>

</div>

@endsection



@section('content')



<div class="row">

	<div class="col-md-12">

		<div class="table-responsive">

			<table class="table table-striped custom-table datatable">

				<thead>

					<tr>

						<th>Name</th>

						<th>Email</th>

						<th>Phone</th>

						<th>Location</th>

						<th class="text-nowrap">Company</th>

						<th>Budget</th>
						<th>Wallet</th>

						<th>Status</th>

						<th class="text-right no-sort">Action</th>

					</tr>

				</thead>

				<tbody>

					@foreach ($contractors as $contractor)

					<tr>

						<td>

							<h2 class="table-avatar">

								<a href="javascript:void(0)">{{$contractor->first_name}} {{$contractor->last_name}}</a>

							</h2>

						</td>

						<td>{{ $contractor->email ?? ''}}</td>

						<td>{{$contractor->phone_number ?? ''}}</td>

						<td>{{$contractor->location ?? ''}}</td>

						<td>{{$contractor->company->name ?? ''}}</td>

						<td>

							{{$contractor->budget ?? ''}}

						</td>

						<td class="{{ ($contractor->status == 'pending') ? 'text-warning' : (($contractor->status == 'approved') ? 'text-success' : 'text-danger') }}">{{ 

						ucfirst($contractor->status) }}</td>

						<td class="text-right">
						
							<div class="dropdown dropdown-action">
								<a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a data-id="" class="dropdown-item editbtn" href="{{ route('edit-contractor', $contractor->id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
									<a data-id="{{ $contractor->id }}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
								</div>
							</div>
						

							{{-- <div class="dropdown dropdown-action">

								<a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>

								<div class="dropdown-menu dropdown-menu-right"> --}}

									{{-- <a data-id="{{$employee->id}}" data-firstname="{{$employee->firstname}}" data-lastname="{{$employee->lastname}}" data-email="{{$employee->email}}" data-phone="{{$employee->phone}}" data-avatar="{{$employee->avatar}}" data-company="{{$employee->company}}" data-designation="{{$employee->designation}}" data-department="{{$employee->department}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a> --}}


									{{-- <a data-id="{{$contractor->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Delete</a> --}}

								{{-- </div> --}}

							{{-- </div> --}}

						</td>

					</tr>

					@endforeach

					{{-- <x-modals.delete :route="'employee.destroy'" :title="'Employee'" /> --}}

				</tbody>

			</table>

		</div>

	</div>

</div>





<!-- Delete Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Lead</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <form action="{{route('contractor.distroy')}}" method="post">
                    @method("DELETE")
                    @csrf
                    <input type="hidden" id="delete_id" name="id">
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-primary continue-btn btn-block" type="submit">Delete</button>
                            </div>
                            <div class="col-6">
                                <button data-dismiss="modal" class="btn btn-primary cancel-btn btn-block">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Delete  Modal -->
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

@section('scripts')
<!-- Summernote JS -->
<script src="{{asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.table').on('click','.editbtn',(function(){
           
            $('#edit_project').modal('show');
           
        }));
    });
</script>
@endsection