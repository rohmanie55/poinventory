<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanDetail extends Model
{
    protected $guarded = [];

    public function barang()
    {
        return $this->hasOne('App\Models\Barang', 'id', 'barang_id');
    }
}
