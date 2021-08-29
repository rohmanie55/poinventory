<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id','order_id');
    }

    public function transactions()
    {
        return $this->belongsTo('App\Models\TransactionDetail','order_det_id', 'id');
    }

    public function request()
    {
        return $this->hasOne('App\Models\KanbanDetail', 'id','kanban_det_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Goods', 'id','barang_id');
    }
}
