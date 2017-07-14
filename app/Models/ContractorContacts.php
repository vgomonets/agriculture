<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Контакты контрагента
 */
class ContractorContacts extends Model
{
    public function contact()
    {
        return $this->morphTo();
    }
}
