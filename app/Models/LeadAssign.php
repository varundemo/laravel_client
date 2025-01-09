<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAssign extends Model
{
    use HasFactory;

    protected $table = 'lead_assign';

    protected $fillable = [
        'contractor_id',
        'lead_id',
    ];
    

       // Relationships
       public function contractor()
       {
           return $this->belongsTo(ContractorProfile::class, 'contractor_id');
       }
   
       public function lead()
       {
           return $this->belongsTo(Lead::class, 'lead_id');
       }
}
