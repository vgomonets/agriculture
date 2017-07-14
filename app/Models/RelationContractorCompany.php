<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationContractorCompany extends Model
{

    public $table = 'relation_contractors_companies';

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function contractor()
    {
        return $this->hasOne('App\Models\Contractor', 'id', 'contractor_id');
    }
}
