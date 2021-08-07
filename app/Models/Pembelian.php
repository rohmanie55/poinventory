<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Models\POrder', 'id', 'order_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\PembelianDetail', 'beli_id');
    }
}
