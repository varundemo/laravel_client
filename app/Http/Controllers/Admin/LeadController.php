<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadAssign;
use App\Models\ContractorProfile;
use App\Models\RadiusZip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Wallet;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use App\Models\ContractorService;
use App\Models\Payment;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function leadView()
    {
        $auth_id = Auth::id();
        $contractor = ContractorProfile::where('user_id',$auth_id)->first();
        
        $title = 'Leads';
        $Leads = Lead::get();
        if (Gate::allows('super-admin')) {
             $Leads = Lead::leftjoin('lead_assign','leads.id', '=', 'lead_assign.lead_id')->leftjoin('contractor_profiles','contractor_profiles.id','=','lead_assign.contractor_id')->select('leads.*', 'lead_assign.contractor_id','contractor_profiles.first_name', 'contractor_profiles.last_name')->latest()->get();
        }else if(Gate::allows('only-contractor')){
             $Leads = Lead::leftjoin('lead_assign','leads.id', '=', 'lead_assign.lead_id')->leftjoin('contractor_profiles','contractor_profiles.id','=','lead_assign.contractor_id')->select('leads.*', 'lead_assign.contractor_id','contractor_profiles.first_name','contractor_profiles.last_name')->where('contractor_id',$contractor->id)->latest()->get();
        }else{
            abort(403, 'Unauthorized');
        }
        // dd($Leads);
        return view('backend.leads.view',compact('title','Leads'));
    }

    public function leadCreate()
    {
        $title = 'Create Lead';
        return view('backend.leads.create',compact('title'));
    }
    
    public function leadSingleView($id){
        $title = 'View Lead';
        $Lead = Lead::find($id);
        $contractor_assign = LeadAssign::with('contractor')->where('lead_id',$id)->first();
        $contractor = ContractorProfile::where('status','approved')->whereDoesntHave('users', function ($query) {
            $query->where('role_id', 1);
        })->get();

        return view('backend.leads.leadview',compact('title','id','Lead','contractor_assign','contractor'));
    }

    public function leadEdit($id)
    {
        $title = 'Edit Lead';
        $Lead = Lead::find($id);
         $service_price = Service::where('name',$Lead->category)->pluck('price')->first();
         $category = $Lead->category;
        $contractor_assign = LeadAssign::with('contractor')->where('lead_id',$id)->first();
        $contractors = ContractorProfile::where('status','approved')->whereDoesntHave('users', function ($query) {
            $query->where('role_id', 1);
        })
        ->whereHas('services', function ($query) use ($category) {
            $query->where('service_name', $category);
        })
        ->whereHas('wallets', function ($query) use ($service_price) {
            $query->where('balance', '>', $service_price);
        })
        ->get();
        
         // Get contractor IDs with matching zip code
        $matchingContractorIds = RadiusZip::whereIn('contractor_id', $contractors->pluck('id'))
            ->where('zip_code', $Lead->zip)
                ->pluck('contractor_id');
                
         $contractor = $contractors->whereIn('id', $matchingContractorIds);
        // dd($Lead);
        $marketsharp_contract =  ContractorProfile::with('company')->where('marketsharp_contractor','1')->get();
        
       // dd($marketsharp_contract);
        
        return view('backend.leads.edit',compact('title','id','Lead','contractor_assign','contractor','marketsharp_contract'));
    }

    public function get_service($id){
        if($id == "ac"){
            $data = config('const.air_conditioning');
        }
        else if($id == "carpentry"){
            $data = config('const.Carpentry');
        }
        else if($id == "concrete"){
            $data = config('const.Concrete');
        }
        else if($id == "Painting"){
            $data = config('const.Painting');
        }
        else if($id == "Drywall"){
            $data = config('const.Drywall_Services');
        }
        else if($id == "Electrical"){
            $data = config('const.Electrical_Services');
        }
        else if($id == "Plumbing"){
            $data = config('const.Plumbing_Services');
        }
        else if($id == "Remodeling"){
            $data = config('const.Remodeling_Services');
        }
        else if($id == "Roofing"){
            $data = config('const.Roofing_Services');
        }
        else if($id == "Pest"){
            $data = config('const.Pest_Services');
        }
        else if($id == "Handyman"){
            $data = config('const.Handyman_Services');
        }
        else if($id == "ac_service"){
            $data = config('const.ac_service');
        }
        else if($id == "carpentry_closet"){
            $data = config('const.carpentry_closet');
        }
        else if($id == "carpentry_finish"){
            $data = config('const.carpentry_finish');
        }
        else if($id == "carpentry_door"){
            $data = config('const.carpentry_door');
        }
        else if($id == "carpentry_deck"){
            $data = config('const.carpentry_deck');
        }
        else if($id == "carpentry_stairs"){
            $data = config('const.carpentry_stairs');
        }
        else if($id == "carpentry_cabinets"){
            $data = config('const.carpentry_cabinets');
        }   
        else if($id == "carpentry_closets"){
            $data = config('const.carpentry_closets');
        }
        else if($id == "carpentry_interior"){
            $data = config('const.carpentry_interior');
        }
        else if($id == "carpentry_exterior"){
            $data = config('const.carpentry_exterior');
        }
        else if($id == "plumbling_faucets"){
            $data = config('const.plumbling_faucets');
        }
        else if($id == "plumbling_water_heater"){
            $data = config('const.plumbling_water_heater');
        }
        else if($id == "plumbing_drain"){
            $data = config('const.plumbing_drain');
        }
        else if($id == "plumbing_gas"){
            $data = config('const.plumbing_gas');
        }
        else if($id == "plumbing_pump"){
            $data = config('const.plumbing_pump');
        }
        else if($id == "plumbing_sewers"){
            $data = config('const.plumbing_sewers');
        }
        else if($id == "roofing_replace_repair"){
            $data = config('const.roofing_replace_repair');
        }
        else if($id == "roofing_gutter"){
            $data = config('const.roofing_gutter');
        }
        else if($id == "roofing_skylights"){
            $data = config('const.roofing_skylights');
        }
        

        
        return response()->json(json_encode($data));
    }

    public function savelead(Request $request){
        
       
         //dd($contractor_services, $request->category);
        $request->validate([
            'category'=>'required',
            'service'=>'required',
            'name' => 'required',
             'phone' =>[
                'required',
            ],
            'email' => 'required|email',
            'zip'=>'required',
            'service_location'=>'required',
            'address'=>'required',
            'state'=>'required',
            'country'=>'required',
            'city'=>'required'
        ]);

        $category = $request->category;
        $Lead = (new Lead())->saveLeadData($request);
        
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
        
       // dd($contractor_id);

        if(!empty($contractor_id)){
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
            
             $contractors = ContractorProfile::whereDoesntHave('users', function ($query) {
                    $query->where('role_id', 1);
                })
                ->whereHas('services', function ($query) use ($category) {
                    $query->where('service_name', $category);
                })
                ->where('budget', '>', $service_cost) 
                ->get()
                ->toArray();
                
                // dd($contractors);

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

        return back()->with('success',"Lead has been created.");

    }
    
    public function updatelead(Request $request, $id){
        // dd($request->all());
        $request->validate([
            'category'=>'required',
            // 'project'=>'required',
            'service'=>'required',
            'name' => 'required',
            // 'phone' => 'required|numeric',
             'phone'=>[
                'required',
            ],
            'email' => 'required|email',
            'zip'=>'required',
            'service_location'=>'required',
            // 'appraisals_detail'=>'required',
            'address'=>'required',
            'state'=>'required',
            'country'=>'required',
            'city'=>'required'
        ]);

        $Lead = (new Lead())->saveLeadData($request, $id);
        
         $category = $request->category;
        $service = Service::where('name', $category)->first();
        $service_cost = $service->price;
        LeadAssign::where('lead_id',$Lead->id)->delete();

        $contractor_ids = $request->contractor_id;
        
        //dd($contractor_ids);
        
        if(isset($contractor_ids) && !empty($contractor_ids) && $contractor_ids != "unassigned"){
        foreach ($contractor_ids as $contractor_id) {
            $wallet = Wallet::where('contractor_id', $contractor_id)->first();
            $old_balance = (!empty($wallet->balance)) ? $wallet->balance : 0;

            if (!empty($wallet) && ($wallet->balance > $service_cost)) {
                $new_balance = $old_balance - $service_cost;
                $wallet->balance = $new_balance;
                $wallet->save();

                $Payment = new Payment();
                $Payment->contractor_id = $contractor_id;
                $Payment->amount = $service_cost;
                $Payment->payment_id = 'db_' . Str::random(24);
                $Payment->currency = 'usd';
                $Payment->captured = '1';
                $Payment->paid = '1';
                $Payment->status = 'succeeded';
                $Payment->transaction_type = 'Debited';
                $Payment->save();
        
                $LeadAssign = new LeadAssign(); // Assuming you need to create a new instance for each contractor_id
                $LeadAssign->contractor_id = $contractor_id;
                $LeadAssign->lead_id = $Lead->id;
                $LeadAssign->save();
            } else {
                $contractor_id = "unassigned";
        
                $LeadAssign = new LeadAssign(); // Assuming you need to create a new instance for each contractor_id
                $LeadAssign->contractor_id = $contractor_id;
                $LeadAssign->lead_id = $Lead->id;
            }
        }
        }else{
            $contractor_id = "unassigned";
        
                $LeadAssign = new LeadAssign(); // Assuming you need to create a new instance for each contractor_id
                $LeadAssign->contractor_id = $contractor_id;
                $LeadAssign->lead_id = $Lead->id;
        }
        
         return back()->with('success', "Lead(s) have been updated successfully.");
       /* if(!empty($LeadAssign)){
            $LeadAssign->contractor_id = $request->contractor_id;
            $LeadAssign->save();    
        }else{
            $NewAssign = new LeadAssign();
            $NewAssign->lead_id = $Lead->id;
            $NewAssign->contractor_id = $request->contractor_id;
            $NewAssign->location = $request->zip;
            $NewAssign->save();
        } */
        

        //return back()->with('success',"Lead has been updated successfully.");
    }
    
    public function destroy(Request $request)
    {
        $lead = Lead::find($request->id);
        $lead->delete();
        LeadAssign::where('lead_id',$request->id)->delete();
        return back()->with('success','Lead has been deleted');
    }
}
