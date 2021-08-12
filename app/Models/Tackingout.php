<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tackingout extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\TackingoutDetail', 'tacking_id');
    }
}
