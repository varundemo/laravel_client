<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function contractor(){
        return $this->hasOne(ContractorProfile::class,'id','contractor_id');
    }

    public function savepaymentdetails($request, $id){
        $this->contractor_id = $id;
        $this->payment_id = $request->id;
        $this->amount = $request->amount/100;
        $this->captured = $request->captured;
        $this->currency = $request->currency;
        $this->paid = $request->paid;
        $this->payment_method = $request->payment_method;
        $this->card_type = $request->payment_method_details->card->brand;
        $this->receipt_url = $request->receipt_url;
        $this->transaction_type = 'Credited';
        $this->status = $request->status;
        $this->save();
        
        return $this;
    }
}
