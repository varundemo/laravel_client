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

						<div class="col-sm-4">

							<div class="form-group">

								<label class="col-form-label">First Name <span class="text-danger">*</span></label>

								<input class="form-control" name="first_name" type="text" value="{{ $contractor->first_name }}">

							</div>

						</div>

						<div class="col-sm-4">

							<div class="form-group">

								<label class="col-form-label">Last Name</label>

								<input class="form-control" name="last_name" type="text" value="{{ $contractor->last_name }}">

							</div>

						</div>

						

						<div class="col-sm-4">

							<div class="form-group">

								<label class="col-form-label">Email <span class="text-danger">*</span></label>

								<input class="form-control" name="email" type="email" value="{{ $contractor->email }}">

							</div>

						</div>

						

						<div class="col-sm-4">

							<div class="form-group">

								<label class="col-form-label">Phone </label>

								<input class="form-control" name="phone_number" type="text" value="{{ $contractor->phone_number }}">

							</div>

						</div>

						<div class="col-sm-4">

							<div class="form-group">

								<label class="col-form-label">Company Name</label>

								<input type="text" class="form-control" name="company_name" value="{{ $contractor->company->name ?? '' }}">

							</div>

						</div>

						<div class="col-md-4">

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
								
								<div class="input-group">
									<div class="input-group-prepend "><span class="input-group-text"><i class="fa fa-dollar"></i></span></div>
									<input class="form-control floating" name="budget" type="text" value="{{ $contractor->budget }}">
								  </div>

								

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
								<div class="input-group">
									<div class="input-group-prepend "> <span class="input-group-text"><i class="fa fa-dollar"></i></span></div>
									<input class="form-control" type="text" id="wallet-amount" value="{{ $contractor->wallets->balance ?? '00.00' }}" readonly />
								</div>
							</div>
			            </div>
						
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="wallet-amount">Is it Marketsharp Contractor?</label>
								<div class="input-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="MsharpContractor" id="MsharpContractor1" value="1" 
                                            @if($contractor->marketsharp_contractor == "1") checked @endif>
                                        <label class="form-check-label" for="MsharpContractor1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="MsharpContractor" id="MsharpContractor2" value="0" @if($contractor->marketsharp_contractor == "0") checked @endif>
                                        <label class="form-check-label" for="MsharpContractor2">No</label>
                                    </div>
                                </div>
                                                            
							</div>
			            </div>
			            
		            

                        <div class="col-md-12">
							<div class="form-group" id="leadCaptureFormCode" style="display:none;">
								<label class="col-form-label">Add Lead Capture Form Code Here<span class="text-danger">*</span></label>
								<textarea class="form-control" rows="5" name="lead_capture_code">
                                    {{ $contractor->lead_capture_code ?? '' }}
                                </textarea>
							</div>

							<div class="form-group">

								<label class="col-form-label">Services<span class="text-danger">*</span></label><br>

                                @foreach (config('const.services') as $service)

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" value="{{ $service }}" id="{{ $loop->iteration }}-electricalCheck" name="services[]" @if (in_array($service,$serviceNames))
                                        checked
                                        @endif >

                                    <label class="form-check-label" for="{{ $loop->iteration }}-electricalCheck">

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
       
    </div>	
	
	<label class="mt-3">Radius Zip Codes</label>
<textarea id="textarea_values" class="form-control mb-4 zipcodes_textarea" rows="6">@foreach($radius_zip as $key=>$item)@if ($key>0){{$item->zip_code}},@endif @endforeach</textarea>
<div id="result"></div>		
							
	
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
	
    let check_value = $('input:radio[name="MsharpContractor"]:checked').val();
    console.log(check_value);
    console.log("check value");
    if (check_value == '1') {
        $('#leadCaptureFormCode').show();
    }else{
        $('#leadCaptureFormCode').hide();
    }

	$('input:radio[name="MsharpContractor"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == '1') {
            $('#leadCaptureFormCode').show();
        }else{
			$('#leadCaptureFormCode').hide();
		}
    });
	
		
	var textareaValue = $("#textarea_values").val();
	var valueArray = textareaValue.split(',').map(function(item) {
		return item.trim();
	});

	// Clear previous results
	$("#result").empty();

	// Generate and append the HTML for each value
	valueArray.forEach(function(item) {
		if (item) { // Check if the item is not empty
			var divElement = $("<div>");
			var inputElement = $("<input>")
				.attr("type", "hidden")
				.attr("name", "radius_zip[]")
				.attr("value", item)
				.addClass("form-control");
			divElement.append(inputElement);
			$("#result").append(divElement);
		}
	});
	
	$("#textarea_values").on("input", function() {
		var textareaValue = $(this).val();
		var valueArray = textareaValue.split(',').map(function(item) {
			return item.trim();
		});

		// Clear previous results
		$("#result").empty();

		// Generate and append the HTML for each value
		valueArray.forEach(function(item) {
			if (item) { // Check if the item is not empty
				var divElement = $("<div>");
				var inputElement = $("<input>")
					.attr("type", "hidden")
					.attr("name", "radius_zip[]")
					.attr("value", item)
					.addClass("form-control");
				divElement.append(inputElement);
				$("#result").append(divElement);
			}
		});
	});
	
});
</script>

@endsection