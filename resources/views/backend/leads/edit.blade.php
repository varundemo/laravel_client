@extends('layouts.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">{{ $title }}</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('leads')}}">Leads</a></li>
			<li class="breadcrumb-item active">{{ $title }}</li>
		</ul>
	</div>	
</div>
@endsection


@section('content')
    @can('super-admin')
    <form action="{{ route('update-lead', $Lead->id) }}" method="post" enctype="multipart/form-data">
    @else
    <form action="" method="" enctype="multipart/form-data">
    @endcan
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Which Service you are looking for?</label>
                <select class="form-control" id="category-box" name="category">
                    <option value="">Select Services</option>
                    @foreach (config('const.services') as $service)
                       <option value="{{$service}}"  {{ (($Lead->category == $service) ?
                       'selected' : '') }}>{{ $service }}</option>
                    @endforeach
                </select>
            </div>
        </div>       
    </div>
    <hr/>
    <div class="card">
        <div class="card-header">
            <h4 id="project-heading">Air Conditioning</h4>
        </div>
        <div class="card-body">
        <div class="row">
        <div class="col-sm-6" id="project-body">
            <div class="form-group">
                <label>What is the type of your project?</label>
                <select class="form-control" name="project" id="project">
                </select>
            </div>
        </div>
        <div class="col-sm-6" id="service-body">
            <div class="form-group">
                <label id="service-label">Select Service</label>
                <select class="form-control" name="service" id="service">
                    {{-- <option>Install or Replace</option>
                    <option>Service or Repair</option>
                    <option>Clean (Only for ducts & vents)</option> --}}
                </select>
            </div>
        </div>
        
    </div>
        </div>
    </div>
    
    
    
    <hr/>
    <h4>Basic Information</h4>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Location of service needed</label>
                <select class="form-control" name="service_location">
                    <option value="Home" @if($Lead->service_location == "Home") selected @endif>Home</option>
                    <option value="Business"    @if($Lead->service_location == "Business") selected @endif>Business</option>
                </select>
            </div>
            <div class="form-group">
                <label>Add details for more exact appraisals.</label>
                <textarea rows="6" class="form-control" name="appraisals_detail" style="height:145px;">{{ $Lead->appraisals_detail ?? 'N/A'  }}</textarea>
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" class="form-control" name="state" value="{{ $Lead->state ?? 'N/A'  }}" />
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" name="name" value="{{ $Lead->name ?? 'N/A'  }}" />
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" value="{{ $Lead->phone ?? 'N/A'  }}" />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="{{ $Lead->email ?? 'N/A'  }}" />
            </div>
            <div class="form-group">
                <label>Zip</label>
                <input type="text" class="form-control" name="zip" value="{{ $Lead->zip ?? 'N/A'  }}" />
            </div>
            
             <div class="form-group">
                <label for="">Assign Contractor  {{ $Lead->contractor_id }}</label>
                <select class="form-control" name="contractor_id" id="">
                    <option value="unassigned" @if (!empty($contractor_assign->contractor_id ) && $contractor_assign->contractor_id == "unassigned") selected   @endif>Not Assigned</option>
                    @foreach ($contractor as $item)
                        <option value="{{ $item->id }}" @if(!empty($contractor_assign->contractor) && $item->id == $contractor_assign->contractor->id) selected @endif>{{ $item->first_name }} {{ $item->last_name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Address</label>
                <textarea rows="7" class="form-control" name="address" style="height:145px;">{{ $Lead->address ?? 'N/A'  }}</textarea>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" class="form-control" name="city" value="{{ $Lead->city ?? 'N/A'  }}" />
            </div>
            
            
            <div class="form-group">
                <label>Country</label>
                <select class="form-control" name="country" id="Country">
                    <option value="">Select Country</option>
                    <option value="US" @if($Lead->country == "US") selected @endif>US</option>
                </select>
            </div>
            
             
            
        </div>       
       
        
    </div>
	<div class="row">
        <div class="col-sm-4">
		<div class="form-group">

                <label class="col-form-label">Assign Contractor<span class="text-danger">*</span></label><br>
                <?php 
                $assign_contract = \App\Models\LeadAssign::where('lead_id',$Lead->id)->pluck('contractor_id')->toArray();
                ?>

                  @foreach ($contractor as $key=>$item)

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="electricalCheck{{$key}}" name="contractor_id[]" 
                        @if(in_array($item->id, $assign_contract)) 
                            checked 
                        @endif
                         >
                        <label class="form-check-label" for="electricalCheck{{$key}}">
                        {{ $item->first_name }} {{ $item->last_name }} 
                        </label>
                    </div> 
                  @endforeach
            </div>
		</div>

		{{-- <div class="col-sm-4">
			<div class="form-group">
                <label>Select Marketsharp Contractor</label>
                <select class="form-control" name="marketsharp_contractor" id="marketsharp_contractor_option">
                    <option value="">Select</option>
					<option value="marketsharp_contractor1" {{ (($Lead->marketsharp_contractor1 == "marketsharp_contractor1") ?
                        'selected' : '') }} >Modern Roofing</option>
                    <option value="marketsharp_contractor2" {{ (($Lead->marketsharp_contractor1 == "marketsharp_contractor2") ?
                        'selected' : '') }}>AI Construction Solutions</option>
                </select>
            </div>
		</div> --}}

        <div class="col-sm-4">
			<div class="form-group">
                <label>Select Marketsharp Contractor</label>
                <select class="form-control" name="marketsharp_contractor" id="marketsharp_contractor_option">
                    <option value="">Select</option>
                    @foreach ($marketsharp_contract as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->first_name }} {{ $item->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
                <label style="width:100%;">&nbsp;</label>
                @can('super-admin')
					<button type="submit" class="btn btn-primary submit-btn">Submit</button>
				 @endcan 
            </div>
            
		</div>
	</div>
     
</form>

@php
    // Split the name by space
    $nameParts = explode(' ', $Lead->name ?? '');

    // Extract first name and last name
    $first_name = isset($nameParts[0]) ? $nameParts[0] : 'N/A';
    $last_name = isset($nameParts[1]) ? $nameParts[1] : $nameParts[0];
@endphp

 {{-- @dd($marketsharp_contract) --}}

 @foreach ($marketsharp_contract as $item)
        {!! $item->lead_capture_code !!}
 @endforeach

{{-- @include('backend.components.modal_marketsharp_contractor1')
@include('backend.components.modal_marketsharp_contractor2') --}}

{{-- <div class="modal fade" id="marketsharp_contractor1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modern Roofing</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <p>Please check below lead information before sending to the markesharp contractor</p>
        <div id="contractor_data">

        </div>
    </div>      
</div>
</div>
</div> --}}

<div id="contractor_data">

</div>

@endsection


@section('scripts')
<!-- Summernote JS -->
<script src="{{asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>


<script>
     $(document).ready(function () {
        let cat_value = $('#category-box option:selected').val();
        
        if(cat_value == "Air Conditioning"){
            let lead_project = {!! json_encode(html_entity_decode($Lead->project)) !!};
            change_project_edit("ac", lead_project);
            if(lead_project == "Ducts & Vents (Install, Repair or Clean)"){
                console.log("lead running ---");
                let lead_service = "{{ $Lead->service }}";
                $("#service-label").text("Type of service needed?");
                $.get(`{{ url('get-service/ac_service') }}`, (res)=>{
                    let ac_data = JSON.parse(res);
                    var options = ac_data.map((item) => {
                        console.log("item", item);
                        if (item == lead_service) { // Check if current item matches old_proj
                            return `<option value="${item}" selected>${item}</option>`; // Add selected attribute
                        } else {
                            return `<option value="${item}">${item}</option>`;
                        }
                    });
                    var optionsHtml = options.join('');
                    $('#service').html(optionsHtml);
                    let selct = (lead_service == "Clean") ? "selected" : "";
                    $('#service').append(`<option value="Clean" ${selct}>Clean</option>`);
                });
            }else{
                change_service_edit("ac_service", "{{ $Lead->service }}");
            }
        }
        else if(cat_value == "Carpentry"){
              let lead_service = "{{ $Lead->service }}";
                reverse_service();
                change_service_edit("carpentry",  lead_service);
                if(lead_service == "Decks, Porches, Ramps"){
                    // change_project("carpentry_deck");
                    change_project_edit("carpentry_deck", "{{ $Lead->project }}" );
                }
                else if(lead_service == "Closets or Built-in furniture"){
                    change_project_edit("carpentry_closets", "{{ $Lead->project }}" );
                }
                else if(lead_service == "Finish Carpentry, Trim, Moulding"){
                    change_project_edit("carpentry_finish", "{{ $Lead->project }}" );
                }
                else if(lead_service == "Doors (Install or Repair)"){
                    change_project_edit("carpentry_door", "{{ $Lead->project }}" );
                }
                else if(lead_service == "Decks, Porches, Ramps"){
                    change_project_edit("carpentry_deck", "{{ $Lead->project }}" );
                }
                else if(lead_service == "Stairs and Railings (Install or Repair)"){
                    change_project_edit("carpentry_stairs", "{{ $Lead->project }}" );
                }
                else if(lead_service == "Cabinets or Drawers (Install or Repair)"){
                    change_project_edit("carpentry_cabinets", "{{ $Lead->project }}" );
                }
                else if(lead_service == "Framing"){
                    $("#project-body").hide();
                    $("#project").prop("disabled", true);
                }
        }
        else if(cat_value == "Concrete"){
            let lead_service = "{{ $Lead->service }}";
            change_service_edit("concrete",  lead_service);
            $("#project-body").hide();
            $("#project").prop("disabled", true);
        }
        else if(cat_value == "Drywall"){
            let lead_service = "{{ $Lead->service }}";
            $("#project-body").hide();
            $("#project").prop("disabled", true);
            change_service_edit(cat_value, lead_service);
        }
        else if(cat_value == "Painting"){
            let lead_service = "{{ $Lead->service }}";
            reverse_service();
            change_service_edit(cat_value,  lead_service);
            // change_project("carpentry_interior");
            if(lead_service == "Interior Paint or Staining"){
                change_project_edit("carpentry_interior", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Exterior Paint or Staining"){
                change_project_edit("carpentry_exterior", "{{ $Lead->project }}" );
            }
        }
        else if(cat_value == "Electrical"){
            let lead_service = "{{ $Lead->service }}";
            $("#project-body").hide();
            $("#project").prop("disabled", true);
            change_service_edit(cat_value, lead_service);
        }
        else if (cat_value == "Plumbing"){
            let lead_service = "{{ $Lead->service }}";
            reverse_service();
            change_service_edit(cat_value,  lead_service);
            if(lead_service == "Faucets, Fixtures, and Pipes (Repair or Install)"){
                change_project_edit("plumbling_faucets", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Water Heaters"){
                change_project_edit("plumbling_water_heater", "{{ $Lead->project }}" );
            }   
            else if(lead_service == "Drain Clearing"){
                change_project_edit("plumbing_drain", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Gas Piping (Repair or Install)"){
                change_project_edit("plumbing_gas", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Pumps"){
                change_project_edit("plumbing_pump", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Sewers, Main Water Lines, Septic"){
                change_project_edit("plumbing_sewers", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Sink Install"){
                $("#project-body").hide();
                    $("#project").prop("disabled", true);
            }
            else if(lead_service == "Toilet Install"){
                $("#project-body").hide();
                $("#project").prop("disabled", true);
            }
            else if(lead_service == "Water Purification Systems (Repair or Install)"){
                $("#project-body").hide();
                $("#project").prop("disabled", true);
            }
        }
        else if(cat_value == "Remodeling"){
            let lead_service = "{{ $Lead->service }}";
            $("#project-body").hide();
            $("#project").prop("disabled", true);
            change_service_edit(cat_value, lead_service);
        }
        else if(cat_value == "Roofing"){
            let lead_service = "{{ $Lead->service }}";
            reverse_service();
            change_service_edit(cat_value,  lead_service);
            if(lead_service == "Complete Replacement or New Roof"){
                change_project_edit("roofing_replace_repair", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Repair Existing Roof"){
                change_project_edit("roofing_replace_repair", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Gutters"){
                change_project_edit("roofing_gutter", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Skylights"){
                change_project_edit("roofing_skylights", "{{ $Lead->project }}" );
            }
            else if(lead_service == "Roof Cleaning"){
                $("#project-body").hide();
                $("#project").prop("disabled", true);
            }
            else if(lead_service == "Roof Snow and Ice Dam Removal"){
                $("#project-body").hide();
                $("#project").prop("disabled", true);
            }
        }
        else if(cat_value == "Pest Control"){
            let lead_service = "{{ $Lead->service }}";
            $("#project-body").hide();
            $("#project").prop("disabled", true);
            change_service_edit("Pest",  lead_service);
            $("#service-label").text("Type of Pest");
        }
        else if(cat_value == "Handyman"){
            let lead_service = "{{ $Lead->service }}";
            $("#project-body").hide();
            $("#project").prop("disabled", true);
            change_service_edit(cat_value,  lead_service);
            $("#service-label").text("Handyman");
        }


        let service_value = $('#service');
        console.log("service val");
        console.log(service_value)
        // if(service_value == "Decks, Porches, Ramps"){
        //     change_project("carpentry_deck");
        // }

        $("#category-box").change(function(){
            $("#project-body").css("order","1");
            $("#service-body").css("order","2");
            $("#project-body").show();
            $("#project").prop("disabled", false);

            
            var serviceValue = $(this).val();
            console.log(serviceValue);
            $("#project-heading").text(serviceValue);

            if(serviceValue == "Air Conditioning"){
                console.log("you are here");
                change_project("ac");
                change_service("ac_service");
            }
            else if(serviceValue == "Carpentry"){
                console.log("you are here carpan");
                reverse_service();
                change_service("carpentry");
                change_project("carpentry_closet");

            }
            else if(serviceValue == "Concrete"){
                console.log("you are here carpan");
                // change_project("concrete");
                change_service("concrete");
                $("#project-body").hide();
                $("#project").prop("disabled", true);
            }
            else if(serviceValue == "Painting"){
                console.log("you are here carpan");
                reverse_service();
                change_service(serviceValue);
                // change_project(serviceValue);
                change_project("carpentry_interior");
            }
            else if(serviceValue == "Drywall"){
                console.log("this is Drywall");
                $("#project-body").hide();
                $("#project").prop("disabled", true);
                change_service(serviceValue);
            }
            else if(serviceValue == "Electrical"){
                console.log("this is Electrical");
                $("#project-body").hide();
                $("#project").prop("disabled", true);
                change_service(serviceValue);
            }
            else if(serviceValue == "Plumbing"){
                console.log("this is Plumbing");
                reverse_service();
                change_service(serviceValue);
                change_project("plumbling_faucets");
            }
            else if(serviceValue == "Remodeling"){
                console.log("this is Remodeling");
                $("#project-body").hide();
                $("#project").prop("disabled", true);
                change_service(serviceValue);
            }
            else if(serviceValue == "Roofing"){
                console.log("this is Roofing");
                reverse_service();
                change_service(serviceValue);
                change_project('roofing_replace_repair');
            }
            else if(serviceValue == "Pest Control"){
                console.log("this is Pest Control");
                $("#project-body").hide();
                $("#project").prop("disabled", true);
                change_service("Pest");
                $("#service-label").text("Type of Pest");
            }
            else if(serviceValue == "Handyman"){
                console.log("this is Handyman");
                $("#project-body").hide();
                $("#project").prop("disabled", true);
                change_service(serviceValue);
                $("#service-label").text("Handyman");
            }
        });

        function change_project(para){
            $.get(`{{ url('get-service/${para}') }}`, (res)=>{
                    let ac_data = JSON.parse(res);
                    console.log(ac_data);
                    var options = ac_data.map(item => `<option value="${item}">${item}</option>`);
                    var optionsHtml = options.join('');
                    $('#project').html(optionsHtml);
                });
        }
        function change_project_edit(para, old_proj) {
            $.get(`{{ url('get-service/${para}') }}`, (res) => {
                let ac_data = JSON.parse(res);
                var options = ac_data.map((item) => {
                    console.log("item", item);
                    console.log("old proj", old_proj);
                    if (item == old_proj) { // Check if current item matches old_proj
                        console.log("old one");
                        return `<option value="${item}" selected>${item}</option>`; // Add selected attribute
                    } else {
                        console.log("new one");
                        return `<option value="${item}">${item}</option>`;
                    }
                });
                var optionsHtml = options.join('');
                $('#project').html(optionsHtml);
            });
        }

        function change_service(para){
          
            $("#service-label").text("Type of service needed?");
            $.get(`{{ url('get-service/${para}') }}`, (res)=>{
                let ac_data = JSON.parse(res);
                var options = ac_data.map(item => `<option value="${item}">${item}</option>`);
                var optionsHtml = options.join('');
                $('#service').html(optionsHtml);
            });
        }
        function change_service_edit(para, old_ser){
            console.log("run service");
           console.log(old_ser);
            $("#service-label").text("Type of service needed?");
            $.get(`{{ url('get-service/${para}') }}`, (res)=>{
                let ac_data = JSON.parse(res);
                // var options = ac_data.map(item => `<option value="${item}">${item}</option>`);
                var options = ac_data.map((item) => {
                    console.log("item", item);
                    if (item == old_ser) { // Check if current item matches old_proj
                        console.log("old one");
                        return `<option value="${item}" selected>${item}</option>`; // Add selected attribute
                    } else {
                        console.log("new one");
                        return `<option value="${item}">${item}</option>`;
                    }
                });
                var optionsHtml = options.join('');
                $('#service').html(optionsHtml);
            });
        }
        function reverse_service(){
            $("#project-body").css("order","2");
            $("#service-body").css("order","1");
        }

        $("#project").change(function(){
            console.log("you change project");
            let cat_value = $('#category-box option:selected').val();
            console.log(cat_value);
            var projValue = $(this).val();
            console.log(projValue);
            if(cat_value == "Air Conditioning"){
                if(projValue == "Ducts & Vents (Install, Repair or Clean)"){
                    $('#service').append(`<option value="Clean">Clean</option>`);
                }
                else{
                    change_service("ac_service");
                }
            }

            // if(cat_value == "Carpentry"){
            //     if(projValue == "Finish Carpentry, Trim, Moulding"){
            //         change_service("carpentry_finish");
            //     }
            // }
            
        });

        $("#service").change(function(){
            // $("#project-body").show();
            var cat_value = $('#category-box option:selected').val();
            var servValue = $(this).val();
            if(cat_value == "Carpentry"){
                $("#project-body").show();
                $("#project").prop("disabled", false);

                if(servValue == "Finish Carpentry, Trim, Moulding"){
                    change_project("carpentry_finish");
                }
                else if(servValue == "Doors (Install or Repair)"){
                    change_project("carpentry_door");
                }
                else if(servValue == "Decks, Porches, Ramps"){
                    change_project("carpentry_deck");
                }
                else if(servValue == "Stairs and Railings (Install or Repair)"){
                    change_project("carpentry_stairs");
                }
                else if(servValue == "Cabinets or Drawers (Install or Repair)"){
                    change_project("carpentry_cabinets");
                }
                else if(servValue == "Framing"){
                    $("#project-body").hide();
                    $("#project").prop("disabled", true);
                }
                else if(servValue == "Closets or Built-in furniture"){
                    change_project("carpentry_closets");
                }
            }
            else if((cat_value == "Painting")){
                if(servValue == "Interior Paint or Staining"){
                    console.log("interior select");
                    change_project("carpentry_interior");
                }
                else if(servValue == "Exterior Paint or Staining"){
                    change_project("carpentry_exterior");
                }
            }
            else if(cat_value == "Plumbing"){
                $("#project-body").show();
                $("#project").prop("disabled", false);

                if(servValue == "Faucets, Fixtures, and Pipes (Repair or Install)"){
                    change_project("plumbling_faucets");
                }
                else if(servValue == "Water Heaters"){
                    change_project("plumbling_water_heater");
                }
                else if(servValue == "Drain Clearing"){
                    change_project("plumbing_drain");
                }
                else if(servValue == "Gas Piping (Repair or Install)"){
                    change_project("plumbing_gas");
                }
                else if(servValue == "Pumps"){
                    change_project("plumbing_pump");
                }
                else if(servValue == "Sewers, Main Water Lines, Septic"){
                    change_project("plumbing_sewers");
                }
                else if(servValue == "Sink Install"){
                    $("#project-body").hide();
                    $("#project").prop("disabled", true);
                }
                else if(servValue == "Toilet Install"){
                    $("#project-body").hide();
                    $("#project").prop("disabled", true);
                }
                else if(servValue == "Water Purification Systems (Repair or Install)"){
                    $("#project-body").hide();
                    $("#project").prop("disabled", true);
                }
            }
            else if(cat_value == "Roofing"){
                $("#project-body").show();
                $("#project").prop("disabled", false);

                if(servValue == "Complete Replacement or New Roof"){
                    change_project('roofing_replace_repair');
                }
                else if(servValue == "Repair Existing Roof"){
                    change_project('roofing_replace_repair');
                }
                else if(servValue == "Gutters"){
                    change_project('roofing_gutter');
                }
                else if(servValue == "Skylights"){
                    change_project('roofing_skylights');
                }
                else if(servValue == "Roof Cleaning"){
                    $("#project-body").hide();
                    $("#project").prop("disabled", true);
                }
                else if(servValue == "Roof Snow and Ice Dam Removal"){
                    $("#project-body").hide();
                    $("#project").prop("disabled", true);
                }
            }
        });
		
		
		
			// $('#marketsharp_contractor_option').change(function() { 
			$('#marketsharp_contractor_option').on("change",function() { 
				var opval = $(this).val();
                console.log("option value")
                console.log(opval)
                $(`#marketsharp_contractor${opval}`).modal("show");
                // $.ajax({
                //     method: 'GET',
                //     url: `{{ url('get-contractor/${opval}') }}`,
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     success: function(response) {
                //         // Refresh the table to display updated values
                //         // location.reload();
                //         $('#marketsharp_contractor1').modal("dispose"); 
                //         console.log("response", response)
                //         let contractor = response.contractor;
                //         let lead_code = response.contractor.lead_capture_code;
                //         console.log(contractor.phone_number, "phone number")
                //         console.log(response.contractor.lead_capture_code);
                //         console.log("contractor data")
                //         $("#contractor_data").html(lead_code);
                //         $("#MSM_firstname").val(response.contractor.first_name);
                //         $("#MSM_lastname").val(response.contractor.last_name);
                //         $("#MSM_cellphone").val(response.contractor.phone_number);
                //         $('#marketsharp_contractor4').modal("show");
                //     },
                //     error: function(error) {
                //         console.log(error);
                //     }
                // });


				// if(opval=="marketsharp_contractor1"){
				// 	$('#marketsharp_contractor1').modal("show"); 
				// }else if(opval=="marketsharp_contractor2"){
				// 	$('#marketsharp_contractor2').modal("show"); 
				// }
			});
		

   });

</script>

@endsection

