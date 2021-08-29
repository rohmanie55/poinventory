<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanDetail extends Model
{
    protected $guarded = [];

    public function kanban()
    {
        return $this->hasOne('App\Models\Kanban', 'id','kanban_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Goods', 'id', 'barang_id');
    }
}
