<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
    ];

    public function employee()
    {
        return $this->belongsTo(ContractorProfile::class);
    }

    public function save_contractor_services($id, $service){
        $this->contractor_id = $id;
        $this->service_name = $service;
        $this->save();
        return $this;
    }
}
