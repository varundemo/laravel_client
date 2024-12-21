<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function leadAssigns()
    {
        return $this->hasMany(LeadAssign::class, 'lead_id');
    }

    public function saveLeadData($request, $id=null){
        if(!empty($id)){
            $Lead = Lead::find($id);
        }else{
            $Lead = new Lead();
        }
        $Lead->category = $request->category;
        $Lead->project = $request->project;
        $Lead->service = $request->service;
        $Lead->name = $request->name;
        $Lead->phone = $request->phone;
        $Lead->email = $request->email;
        $Lead->zip = $request->zip;
        $Lead->service_location = $request->service_location;
        $Lead->appraisals_detail = $request->appraisals_detail;
        $Lead->address = $request->address;
        $Lead->state = $request->state;
        $Lead->country = $request->country;
        $Lead->city = $request->city;
        $Lead->marketsharp_contractor = $request->marketsharp_contractor;
        $Lead->save();
        return $Lead;
    }
}
