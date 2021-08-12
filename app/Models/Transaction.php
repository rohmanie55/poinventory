<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\TransactionDetail', 'trx_id');
    }
}
