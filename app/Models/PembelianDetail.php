<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Models\OrderDetail', 'detail_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Barang', 'id','barang_id');
    }
}
