<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $guarded = [];

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'id','payment_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Goods', 'id','barang_id');
    }
}
