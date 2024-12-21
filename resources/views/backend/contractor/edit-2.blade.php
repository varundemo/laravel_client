@extends('layouts.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Edit Contractor</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('contractors-list')}}">Contractors</a></li>
			<li class="breadcrumb-item active">Edit Contractor</li>
		</ul>
	</div>	
</div>
@endsection


@section('content')
<form method="POST" action="{{route('update-contractor', $contractor->id )}}" enctype="multipart/form-data">

					@csrf

					<div class="row">

						<div class="col-sm-9">

							<div class="row">

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">First Name <span class="text-danger">*</span></label>

								<input class="form-control" name="first_name" type="text" value="{{ $contractor->first_name }}">

							</div>

						</div>

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Last Name</label>

								<input class="form-control" name="last_name" type="text" value="{{ $contractor->last_name }}">

							</div>

						</div>

						

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Email <span class="text-danger">*</span></label>

								<input class="form-control" name="email" type="email" value="{{ $contractor->email }}">

							</div>

						</div>

						

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Phone </label>

								<input class="form-control" name="phone_number" type="text" value="{{ $contractor->phone_number }}">

							</div>

						</div>

						<div class="col-sm-3">

							<div class="form-group">

								<label class="col-form-label">Company Name</label>

								<input type="text" class="form-control" name="company_name" value="{{ $contractor->company->name ?? '' }}">

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<label>Company Address <span class="text-danger">*</span></label>

								<input type="text" class="form-control" name="company_address" value="{{ $contractor->company->address ?? '' }}">

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label>License Number <span class="text-danger">*</span></label>

								<input type="text" class="form-control" name="license_number" value="{{ $contractor->company->license_number ?? '' }}">

							</div>

						</div>
						
						<div class="col-md-4">

							<div class="form-group">

								<label class="">Budget<span class="text-danger">*</span></label>

								<input class="form-control floating" name="budget" type="text" value="{{ $contractor->budget }}">

							</div>

						</div>

					
												
						  <div class="col-md-4" >
                            <div class="form-group">
                                <label id="service-label">Status</label>
                                <select class="form-control" name="status" id="status">
                                    @foreach (config('const.Client_Status') as $status)
                                        <option value="{{ $status }}" @if($status == $contractor->status) selected @endif>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
							<div class="form-group">
								<label for="expiration-date">License Expiration Date</label>
								<input class="form-control" type="date" name="expiration_date" id="expiration-date" value="{{ $contractor->company->expiration_date ?? '' }}">
							</div>
			            </div>

                        <div class="col-md-4">
							<div class="form-group">
								<label for="wallet-amount">Wallet Amount</label>
								<input class="form-control" type="text" id="wallet-amount" value="{{ $contractor->wallets->balance ?? '00.00' }}" readonly>
							</div>
			            </div>
			            
		            

                        <div class="col-md-12">

							<div class="form-group">

								<label class="col-form-label">Services<span class="text-danger">*</span></label><br>

                                @foreach (config('const.services') as $service)

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" value="{{ $service }}" id="electricalCheck" name="services[]" @if (in_array($service,$serviceNames))
                                        checked
                                        @endif >

                                    <label class="form-check-label" for="electricalCheck">

                                      {{ $service }}

                                    </label>

                                  </div> 

                                  @endforeach

							</div>

						</div>

						</div>

					</div>

					<div class="col-sm-3">
							<div class="form-group">
								<label for="radius">Radius</label>
								{{-- <input class="form-control" type="text" name="radius" id="radius" value="{{ $contractor->radius ?? '' }}"> --}}
								<select class="form-control" name="radius" id="radius">
									<option value="30" @if($contractor->radius == 30) selected @endif>30 miles</option>
									<option value="60" @if($contractor->radius == 60) selected @endif>60 miles</option>
									<option value="80" @if($contractor->radius == 80) selected @endif>80 miles</option>
									<option value="100" @if($contractor->radius == 100) selected @endif>100 miles</option>
								</select>
							</div>


							<div class="form-group" style="display:none;">
								
								<input class="form-control floating" name="location" type="text" value="{{ $contractor->location }}" >
							</div>

							
							<div class="field_wrapper ">
							
    <div>
        <label class="">Zip Code<span class="text-danger">*</span></label>
        <input type="text" name="radius_zip[]" value="{{ $contractor->location }}" class="form-control"/>
        <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus"></i></a>
    </div>


								
							@foreach ($radius_zip as $key => $item)
								@if ($key > 0)
									<div>
										<input type="text" name="radius_zip[]" class="form-control" value="{{ $item->zip_code }}" /> 
										<a href="javascript:void(0);" class="remove_button">
											<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
												<path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"/>
											</svg>
										</a>
									</div>
								@endif
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


<script>
	$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = `<div>
						<input type="text" name="radius_zip[]" value="" class="form-control" />
							<a href="javascript:void(0);" class="remove_button">
								<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
									<path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"/>
								</svg>
							</a>
						</div>`; 
				//New input field html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
});
</script>

@endsection