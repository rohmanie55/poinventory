<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function approve()
    {
        return $this->hasOne('App\User', 'id','approve_id');
    }

    public function request()
    {
        return $this->hasOne('App\Models\Kanban', 'id','kanban_id');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\Supplier', 'id','suplier_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }
}
