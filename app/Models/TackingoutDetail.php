<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TackingoutDetail extends Model
{
    protected $guarded = [];

    public function tackingout()
    {
        return $this->hasOne('App\Models\Tackingout', 'id','tacking_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Goods', 'id','barang_id');
    }
}
