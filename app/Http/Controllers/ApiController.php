<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use App\Models\ContractorProfile;
use App\Models\ContractorService;
use App\Models\ContractorCompany;
use App\Models\Lead;
use App\Models\Wallet;
use Illuminate\Support\Str; 
use App\Models\LeadAssign;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContractorRegistration;



class ApiController extends Controller
{
    //

    public function error_msg($error_msg){
        return response()->json([
            'message' => $error_msg,
        ], 400);
    }

    public function storeContractor(Request $request){
        
        // Add other fields here as needed
        $user_data = (new User())->pluck('email')->toArray();

        if(!isset($request->first_name) || empty($request->first_name)){
            $error_msg = 'First Name field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->last_name) || empty($request->last_name)){
            $error_msg = 'Last Name field is reuqired';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->phone_number) || empty($request->phone_number)){
            $error_msg = 'Phone Number field is required';
            return $this->error_msg($error_msg);
        }
        /*if(!is_numeric($request->phone_number)){
            $error_msg = 'Phone Number Your have enetered is not valid';
            return $this->error_msg($error_msg);
        }*/
        if(!isset($request->email) || empty($request->email)){
            $error_msg = 'Email field is required';
            return $this->error_msg($error_msg);
        }
        if(in_array($request->email,$user_data)){
            $error_msg = 'Email Already Exist';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->budget) || empty($request->budget)){
            $error_msg = 'Budget field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->location) || empty($request->location)){
            $error_msg = 'Location field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->services) || empty($request->services)){
            $error_msg = 'Services field is required';
            return $this->error_msg($error_msg);
        }
        if(!is_array($request->services)){
             $error_msg = 'Services field is not properly given';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->company_name) || empty($request->company_name)){
            $error_msg = 'Company Name field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->company_address) || empty($request->company_address)){
            $error_msg = 'Company Address field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->company_website) || empty($request->company_website)){
            $error_msg = 'Company Website field is required';
            return $this->error_msg($error_msg);
        }

        $password = $request->first_name."_1234";
        $user = User::create([
            'role_id' => UserRole::where('name', 'Contractor')->first()->id,
            'name' => $request->first_name." ".$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        $contractor = (new ContractorProfile())->save_contractor($request, $user->id);

        foreach ($request->services as $service) {
            $services = (new ContractorService())->save_contractor_services($contractor->id,$service);
        }

      //  $company = (new ContractorCompany())->save_contractor_company($request, $contractor->id);
      
        $company = new ContractorCompany();
        $company->contractor_id = $contractor->id;
        $company->name = $request->company_name;
        $company->address = $request->company_address;
        $company->website = $request->company_website;
        $company->license_number = $request->license_number;
        $company->license_img = $request->license_img;
        $company->save();
        
          $data = [
                'fullName' => $request->first_name." ".$request->last_name,
                'email' => $request->email,
            ];
        
        
        $mail = Mail::send('backend.emails.index', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['fullName'])
                ->subject('Thank You for Signing Up with Contractors Universe');
        });

        // Return a response to the client
        return response()->json([
            'message' => 'Data stored successfully',
            'data' => "Customer has been added with Username: '{$request->email}' and Password: '{$password}'. Please save these credentials."
        ], 200);
    }
    
    public function storeLead(Request $request){
        
        
        if(!isset($request->category) || empty($request->category)){
            $error_msg = 'Category field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->service) || empty($request->service)){
            $error_msg = 'Service field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->name) || empty($request->name)){
            $error_msg = 'Name field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->phone) || empty($request->phone)){
            $error_msg = 'Phone field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->email) || empty($request->email)){
            $error_msg = 'Email field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->zip) || empty($request->zip)){
            $error_msg = 'Zip field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->service_location) || empty($request->service_location)){
            $error_msg = 'Location field is required';
            return $this->error_msg($error_msg);
        }
        // if(!isset($request->appraisals_detail) || empty($request->appraisals_detail)){
        //     $error_msg = 'Appraisals field is required';
        //     return $this->error_msg($error_msg);
        // }
        if(!isset($request->address) || empty($request->address)){
            $error_msg = 'Address field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->state) || empty($request->state)){
            $error_msg = 'State field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->country) || empty($request->country)){
            $error_msg = 'Country field is required';
            return $this->error_msg($error_msg);
        }
        if(!isset($request->city) || empty($request->city)){
            $error_msg = 'city field is required';
            return $this->error_msg($error_msg);
        }
        
        
       // dd($request->all() , "all your data");
        
        
        
        $Lead = (new Lead())->saveLeadData($request);
        
         $category = $request->category;
        // $service_cost = getBalance($category);
        $service = Service::where('name', $category)->first();
        $service_cost = $service->price;

        $LeadAssign = new LeadAssign();
        $contractor_id = ContractorProfile::where(['location'=>$request->zip,'status'=>'approved'])
                ->whereDoesntHave('users', function ($query) {
                    $query->where('role_id', 1);
                })
                ->whereHas('services', function ($query) use ($category) {
                    $query->where('service_name', $category);
                })
                ->where('budget', '>', $service_cost) 
        ->orderByRaw('CAST(budget AS decimal) DESC')->value('id');
        

        if(!empty($contractor_id)){
            $wallet = Wallet::where('contractor_id',$contractor_id)->first();
              $contractor_detail = ContractorProfile::find($contractor_id);
            
            $data_wallet = [
                'fullName' => $contractor_detail,
                'email' => $contractor_detail->email,
            ];

            if($wallet->balance > 500){
                Mail::send('backend.emails.contractor_wallet', $data_wallet, function ($message) use ($data_wallet) {
                    $message->to($data_wallet['email'], $data_wallet['fullName'])
                        ->subject('Your Wallet Is Below $500');
                });
            }
            
            $old_balance = (!empty($wallet->balance)) ? $wallet->balance : 0;

            if((isset($wallet->balance) && !empty($wallet->balance)) && $wallet->balance > $service_cost){
                $new_balance = $old_balance - $service_cost; 
                $wallet->balance = $new_balance;
                $wallet->save();

                $contractor_id = $contractor_id;
            }
            else{
                $contractor_id = "unassigned";
            }
        }else{
            
             $contractors = ContractorProfile::whereDoesntHave('users', function ($query) {
                    $query->where('role_id', 1);
                })
                ->whereHas('services', function ($query) use ($category) {
                    $query->where('service_name', $category);
                })
                ->where('budget', '>', $service_cost) 
                ->get()
                ->toArray();

                if(!empty($contractors)){
                   $RadiusZip = RadiusZip::where('zip_code',$request->zip)->first();
                    $contractor_id = $RadiusZip->contractor_id;
                   
                        if(!empty($contractor_id)){
                            $contractor_services = ContractorService::where('contractor_id', $contractor_id)->pluck('service_name')->toArray();
                            if(in_array($request->category, $contractor_services)){
                                $wallet = Wallet::where('contractor_id',$contractor_id)->first();
                                $old_balance = (!empty($wallet->balance)) ? $wallet->balance : 0;
            
                                if((isset($wallet->balance) && !empty($wallet->balance)) && $wallet->balance > $service_cost){
                                    $new_balance = $old_balance - $service_cost; 
                                    $wallet->balance = $new_balance;
                                    $wallet->save();
            
                                    $contractor_id = $contractor_id;
                                }else{
                                    $contractor_id = "unassigned";
                                }
                            }else{
                                $contractor_id = "unassigned";
                            }
                        }
                }else{
                    $contractor_id = "unassigned";
                }
            
        }

        $LeadAssign->contractor_id = $contractor_id;
        $LeadAssign->lead_id = $Lead->id;
        $LeadAssign->location = $request->zip;
        $LeadAssign->save();
        
        $data = [
            'fullName' => $request->name,
            'email' => $request->email
        ];

        $mail = Mail::send('backend.emails.new_lead_index', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['fullName'])
                ->subject('Thank You for Choosing Contractors Universe!');
        });
        
        if(!empty($contractor_id) && ($contractor_id != "unassigned")){
            $contractor_detail = ContractorProfile::find($contractor_id);
            $contractor_fullname = $contractor_detail->first_name.' '.$contractor_detail->last_name;
            
              $data = [
                'fullName' => $contractor_fullname,
                'email' => $contractor_detail->email,
                'customer_name'=>$request->name,
                'customer_no'=>$request->phone,
                'customer_project'=>$request->category,
                'customer_zip'=>$request->zip,
                'customer_address'=>$request->address,
                'service_needed'=>$request->service,
                'project'=>$request->project      
            ];
    
            $mail = Mail::send('backend.emails.contractor_lead_index', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['fullName'])
                    ->subject('New Lead from Contractors Universe');
            });
        }

        return response()->json([
            'message' => 'Lead has been Created successfully',
        ], 200);
    }
}


