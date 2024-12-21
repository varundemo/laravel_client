<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\LeadAssign;
use Illuminate\Support\Facades\Gate;
use App\Models\Wallet;
use App\Models\Payment;
use App\Models\ContractorProfile;

class DashboardController extends Controller
{
    public function index(){
        $title = 'Dashboard';
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

         if (Gate::allows('super-admin')) {
        $leadsCount = Lead::whereBetween('created_at', [$startDate, $endDate])->count();
        $balance = 0;
        $amount_spent = 0;
        $total_contractor = ContractorProfile::count();
         }else if(Gate::allows('only-contractor')){
             $contractor_id = getcontractorid(Auth::id());
             $leadsCount = LeadAssign::where('contractor_id',$contractor_id)->count();
             $balance = Wallet::where('contractor_id', $contractor_id)->pluck('balance')->first();
             $totalAmount = Payment::where('contractor_id', $contractor_id)
                     ->sum('amount');
             $amount_spent = $totalAmount - $balance; 
             $total_contractor = 0;
         }else{
              abort(403, 'Unauthorized');
         }
      
        return view('backend.dashboard',compact('title','leadsCount','balance','amount_spent','total_contractor'));
    }		
    
       public function termcondition(){
        $title = '';

        return view('backend.term-and-conditions', compact('title'));
    }
    
     public function service_view(){
        $title = 'Services';
        $services = Service::get();
        return view('backend.services', compact('title','services'));
    }

    public function updatePrice(Request $request)
    {
        $updatedPrices = $request->input('prices');

        foreach ($updatedPrices as $updatedPrice) {
            $service = Service::find($updatedPrice['id']);

            if ($service) {
                $service->price = $updatedPrice['price'];
                $service->save();
            }
        }

        return response()->json(['message' => 'Prices updated successfully']);
    }
	
	public function emails()
    {
        return view('backend.emails.index');
    }


}
