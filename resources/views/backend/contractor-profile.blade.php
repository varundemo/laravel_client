@extends('layouts.backend')

@section('styles')
<style>
    .custom-checkbox {
    padding-top: 5px;
    padding-bottom: 5px;
  }
  </style>
  
	
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <form enctype="multipart/form-data" method="post" action="{{  route('update-contractor', $contractor->id) }}">
        <div class="row">
            <div class="col-md-8 text-center">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h3 class="card-title float-md-left">Profile</h3>
                            </div>
                            <div class="col-12 col-md-6">
                                <h3 class="card-title float-md-right">Edit Details</h3>
                            </div>
                        </div>
                        
                        <div id="bar-charts"></div>
                            @csrf
                            <div class="row text-left">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="first_name" type="text" value="{{ $contractor->first_name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="last_name" type="text" value="{{ $contractor->last_name }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <input class="form-control" name="phone_number" type="text"
                                        value="{{ $contractor->phone_number }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input class="form-control" name="email" type="email" value="{{ $contractor->email }}" >
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <h3 class="card-title float-md-left">Company Details</h3>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Company Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="company_name" type="text" value="{{ $contractor->company->name }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Company Address <span class="text-danger">*</span></label>

                                        <input class="form-control" name="company_address" type="text" value="{{ $contractor->company->address }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Company Website <span class="text-danger">*</span></label>
                                        <input class="form-control" name="company_website" type="text" value="{{ $contractor->company->website }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Budget <span class="text-danger">*</span></label>
                                        <input class="form-control" name="budget" type="text" value="{{ $contractor->budget }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Location <span class="text-danger">*</span>(Zip Code)</label>
                                        <input class="form-control" name="location" type="text" value="{{ $contractor->location }}">
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Radius <span class="text-danger">*</span>(radius)</label>
                                        <input class="form-control" name="radius" type="text" value="{{ $contractor->radius }}" disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-5">Save</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Services </h3>
                            <div class="row text-left">
                                <div class="col-sm-12">
                                    @foreach ($serviceNames as $item)
                                    <div class="form-group">
                                            <div class="form-label" for="Check">
                                            {{ $item }}
                                            </div>
                                        @endforeach
                                    {{-- @foreach (config('const.services') as $service)
                                        <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $service }}" id="electricalCheck" name="services[]" @if (in_array($service,$serviceNames))
                                        checked
                                        @endif >
                                        <label class="form-check-label" for="electricalCheck">
                                          {{ $service }}
                                        </label>
                                      </div> 
                                    @endforeach --}}
                                    </div>

                                  
                                  
                                </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
</div>
@endsection