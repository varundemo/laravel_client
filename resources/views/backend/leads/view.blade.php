@extends('layouts.backend')

Diljit_1234
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
		<h3 class="page-title">Leads</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
			<li class="breadcrumb-item active">leads</li>
		</ul>
	</div>
	 @can('super-admin')
	<div class="col-auto float-right ml-auto">
		<a href="{{route('create-lead')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add New Lead</a>		
	</div>
	@endcan
</div>
@endsection


@section('content')
    
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Assigned Contractor</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th class="text-right no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($Leads as $key=>$Lead)
                      
                  <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>
                          {{ $Lead->name }}
                        </td>
                        <td>{{ $Lead->email }}</td>
                        <td>{{ $Lead->category }}</td>
                        
                        <td>
                              {{-- {{ ( (!empty($Lead->contractor_id) && $Lead->contractor_id != "unassigned") ? $Lead->first_name." ".$Lead->last_name : ucfirst($Lead->contractor_id) ) }} --}}
                              {{ $Lead->contractors ?: 'Unassigned' }}
                        </td>
                        <td>{{ $Lead->zip }}</td>
                        <td>{{ date("Y-m-d", strtotime($Lead->created_at)) }}</td>
                    
                        <td class="text-right">
							<div class="dropdown dropdown-action">
                            <a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a> 
								<div class="dropdown-menu dropdown-menu-right">
                                    @can('super-admin')
                                    <a data-id="" class="dropdown-item editbtn" href="{{ route('edit-lead',$Lead->id) }}" ><i class="fa fa-pencil m-r-5"></i> 
                                      Edit 
                                    </a>
									<a data-id="{{ $Lead->id }}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
									@else 
                                    <a data-id="" class="dropdown-item editbtn" href="{{ route('view-lead',$Lead->id) }}" ><i class="fa fa-pencil m-r-5"></i> 
                                        View
                                      </a>
                                    @endcan


								</div>
							</div>
						</td>
					
                    </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- /Page Content -->

<!-- Delete Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Lead</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <form action="{{route('leads.distroy')}}" method="post">
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
            var id = $(this).data('id');
            var name = $(this).data('name');
            var client = $(this).data('client');
            var startdate = $(this).data('start');
            var enddate = $(this).data('end');
            var rate = $(this).data('rate');
            var rate_type = $(this).data('rtype');
            var priority = $(this).data('priority');
            var leader = $(this).data('leader');
            var team  = $(this).data('team');
            var description = $(this).data('description');
            var progress = $(this).data('progress');
            $('#edit_project').modal('show');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_client').val(client).trigger('change');
            $('#edit_startdate').val(startdate);
            $('#edit_enddate').val(enddate);
            $('#edit_rate').val(rate);
            $('#edit_priority').val(priority);
            $('#edit_leader').val(leader).trigger('change');
            $('#edit_team').val(team).trigger('change');
            $('#edit_description').summernote('code', description);
            $('#edit_progress').val(progress);
            $('#progress_result').html("Progress Value: " + progress);
            $('#edit_progress').change(function(){
                $('#progress_result').html("Progress Value: " + $(this).val());
            });
        }));
    });
</script>
@endsection