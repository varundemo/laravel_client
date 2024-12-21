<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorProfile extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(ContractorService::class, 'contractor_id');
    }
    public function company()
    {
        return $this->hasOne(ContractorCompany::class, 'contractor_id');
    }
    public function users()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function leadAssigns()
    {
        return $this->hasMany(LeadAssign::class, 'contractor_id');
    }

    public function wallets(){
        return $this->hasOne(Wallet::class,'contractor_id');
    }

    public function save_contractor($request, $id){
        $this->user_id = $id;
        $this->first_name = $request->first_name; 
        $this->last_name = $request->last_name; 
        $this->phone_number = $request->phone_number; 
        $this->email = $request->email; 
        $this->budget = $request->budget; 
        $this->location = $request->location; 
        $this->save();
        return $this;
    }

}
