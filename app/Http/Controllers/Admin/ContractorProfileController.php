<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContractorRegistration;
use App\Models\ContractorCompany;
use App\Models\ContractorProfile;
use App\Models\ContractorService;
use App\Models\RadiusZip;
use App\Models\User;
use App\Models\UserRole;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ContractorProfileController extends Controller
{
    public function show(){
        $title = 'Profile';

        $contractor = ContractorProfile::with('company','services')->where('user_id',Auth::id())->first();
        $serviceNames = $contractor->services->pluck('service_name')->toArray();

        return view('backend.contractor-profile',compact('title', 'contractor','serviceNames'));
    }
    
    public function contractCreate(){ 
        $title = 'Create Contract'; 
        return view('backend.contractor.create',compact('title'));
    }
    
    public function edit($id){
        $title = 'Edit Contract';
        $contractor = ContractorProfile::with('company','services','wallets')->where('id',$id)->first();
        $serviceNames = $contractor->services->pluck('service_name')->toArray();

        $radius_zip = RadiusZip::where('contractor_id',$id)->get();

        // foreach ($radius_zip as $item){
        //     echo $item->zip_code;
        // }
        // dd($radius_zip);
        
        // dd($contractor);
        return view('backend.contractor.edit', compact('title','contractor','serviceNames','radius_zip'));
    }

    public function update(Request $request, $id){

        // dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // 'phone_number' => ['required', new Phone],
            // 'phone_number' => 'required|numeric',
            // 'phone_number' =>[
            //     'required','numeric','regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            // ],
            'email' => 'required|email',
            'budget'=>'required',
            'location'=>'required',
            'services'=>'required|array',
            'company_name'=>'required',
            'company_address'=>'required',
            // 'company_website'=>'required',
        ]);

        //dd($request->all(), $id);
        $contractor = ContractorProfile::find($id);

        $user = User::where('id',$contractor->user_id)->first();
        $user->name = $request->first_name." ".$request->last_name;
        $user->email = $request->email;
        $user->save();
        // dd($contractor);
        // $contractor->user_id = Auth::id();
        $contractor->first_name = $request->first_name; 
        $contractor->last_name = $request->last_name; 
        $contractor->phone_number = $request->phone_number; 
        $contractor->email = $request->email; 
        $contractor->budget = $request->budget; 
        $contractor->location = $request->location; 
        $contractor->status = $request->status;
        $contractor->radius = $request->radius;

        // dd($request->MsharpContractor);
        if($request->MsharpContractor == "1"){
            // dd("yes you are in");
            $contractor->marketsharp_contractor = $request->MsharpContractor;
            $contractor->lead_capture_code = $request->lead_capture_code;
        }

        // dd($contractor);

        $contractor->save();

        RadiusZip::where('contractor_id', $contractor->id)->delete();

        $zipCodes = $request->input('radius_zip');

        $filterdZip = array_values(array_filter(array_unique($zipCodes)));

        $contractorId = $contractor->id;
        
        $radiusZips = collect($filterdZip)->map(function ($zip) use ($contractorId) {
            return ['contractor_id' => $contractorId, 'zip_code' => $zip];
        });
        
        RadiusZip::insert($radiusZips->toArray());
       
        // dd($contractor->id);
        // $services = ContractorService::find($id);
        // $services = ContractorService::where('contractor_id', );

        DB::table('contractor_services')->where('contractor_id', $id)->delete();

        // Add the skills to the employee
        foreach ($request->services as $service) {
            $services = new ContractorService();
            $services->contractor_id = $id;
            $services->service_name = $service;
            $services->save();
        }
        
        //dd("right");

        // $company = ContractorCompany::find($id);
        $company = ContractorCompany::where('contractor_id',$id)->first();
        //dd($company);
        $company->contractor_id = $id;
        $company->name = $request->company_name;
        $company->address = $request->company_address;
        $company->website = $request->company_website;
        $company->license_number = $request->license_number;
        $company->expiration_date = $request->expiration_date;
        $company->save();

         return back()->with('success', "Contractor has been Updated.");
    }
    
     public function show_all_contractors(){
        $title="Contractors";
        $contractors = ContractorProfile::with('company','services')->where('user_id',Auth::id())->get();
        return view('backend.contractors',compact('title','contractors'));
    }   
    
    public function show_contractors_list(){
        $title="Contractors";
        $contractors = ContractorProfile::with('company', 'services', 'users','wallets')
                ->whereHas('users.role', function ($query) {
                    $query->where('name', 'Contractor');
                })->get();
                
                // dd($contractors);
        return view('backend.contractors-list',compact('title','contractors'));
    }

    public function store(Request $request){


        // dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // 'phone_number' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'budget'=>'required',
            'location'=>'required',
            'services'=>'required|array',
            'company_name'=>'required',
            'company_address'=>'required',
            'company_website'=>'required',
        ]);




        // $password = $request->first_name."_".Str::random(8);
        $password = $request->first_name."_1234";
        $user = User::create([
            'role_id' => UserRole::where('name', 'Contractor')->first()->id,
            'name' => $request->first_name." ".$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        $contractor = new ContractorProfile();
        $contractor->user_id = $user->id;
        $contractor->first_name = $request->first_name; 
        $contractor->last_name = $request->last_name; 
        $contractor->phone_number = $request->phone_number; 
        $contractor->email = $request->email; 
        $contractor->budget = $request->budget; 
        $contractor->location = $request->location; 

        $contractor->save();

         // Add the skills to the employee
         foreach ($request->services as $service) {
            $services = new ContractorService();
            $services->contractor_id = $contractor->id;
            $services->service_name = $service;
            $services->save();
        }

        $company = new ContractorCompany();
        $company->contractor_id = $contractor->id;
        $company->name = $request->company_name;
        $company->address = $request->company_address;
        $company->website = $request->company_website;
        $company->license_number = $request->license_number;

        if($request->hasfile("license_img")){
            $profile_img = $request->license_img;
            $imgName = time()."_".$profile_img->getClientOriginalName();
            $profile_img->move("assets/img/company/",$imgName);
            $upload = "assets/img/company/".$imgName;
            // print_r($upload);
            $company->license_img = $upload;
        }

        $company->save();

        $fullName = $request->first_name." ".$request->last_name;
        // Mail::to($request->email)->send(new ContractorRegistration($fullName));
        Mail::to($request->email)->queue(new ContractorRegistration($fullName));
      

        return back()->with('success', "Customer has been added with Username: '{$request->email}' and Password: '{$password}'. Please save these credentials.");

    
    }
    
     public function distroy(Request $request){
        $ContractorProfile = ContractorProfile::find($request->id);
        $user_id = $ContractorProfile->user_id;
        User::where('id',$user_id)->delete();
        $ContractorProfile->delete();
        ContractorCompany::where('contractor_id',$request->id)->delete();
        ContractorService::where('contractor_id',$request->id)->delete();

        return back()->with('success','Contractor has been deleted');
    }

    public function addraduis(Request $request){
        // dd("route here---");
        $title = "Add Zip Code";
        return view('backend.radius',compact('title'));
    }

    public function get_contractor(Request $request,$id){
        // dd($request->all(), $id);
        $contractor = ContractorProfile::where('id',$id)->first();
        if ($contractor) {
            // Convert the data to JSON and return as a response
            return response()->json(['contractor' => $contractor]);
        } else {
            // If no contractor is found, return an error response
            return response()->json(['error' => 'Contractor not found'], 404);
        }

    }
}
