<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Заказы
 */
class Order extends Model
{

    public function contractor()
    {
        return $this->hasOne('App\Models\Contractor', 'id', 'contractor_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function orderPayType()
    {
        return $this->hasOne('App\Models\OrderPayType', 'id', 'order_pay_type_id');
    }

    public function orderStatus()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'order_status_id');
    }

}
