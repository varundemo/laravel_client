<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorCompany extends Model
{
    use HasFactory;

    public function contractor()
    {
        return $this->belongsTo(ContractorCompany::class);
    }

    public function save_contractor_company($request, $id){
        $this->contractor_id = $id;
        $this->name = $request->company_name;
        $this->address = $request->company_address;
        $this->website = $request->company_website;
        $this->license_number = $request->license_number;
        if($request->hasfile("license_img")){
            $profile_img = $request->license_img;
            $imgName = time()."_".$profile_img->getClientOriginalName();
            $profile_img->move("assets/img/company/",$imgName);
            $upload = "assets/img/company/".$imgName;
            $this->license_img = $upload;
        }
        $this->save();
        return $this;
    }
}
