<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationContractorContractor extends Model
{
    public function contractorParent()
    {
        return $this->hasOne('App\Models\Company', 'id', 'parent_contractor_id');
    }

    public function contractor()
    {
        return $this->hasOne('App\Models\Contractor', 'id', 'contractor_id');
    }
}
