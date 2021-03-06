<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $guarded = [];

    public function transaction()
    {
        return $this->hasOne('App\Models\Transaction', 'id','trx_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Goods', 'id','barang_id');
    }
}
