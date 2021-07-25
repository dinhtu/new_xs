<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XsDetail extends Model
{
    protected $table = 'xs_detail';
    protected $primaryKey = 'id';

    public function xsDay()
    {
        return $this->hasOne('App\Models\XsDay', 'id', 'xs_day_id');
    }
}