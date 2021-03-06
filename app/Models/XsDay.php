<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XsDay extends Model
{
    protected $table = 'xs_day';
    protected $primaryKey = 'id';

    public function xsDetails()
    {
        return $this->hasMany('App\Models\XsDetail');
    }
    public function xsDetailNext()
    {
        return $this->hasOne('App\Models\XsDetail');
    }
    public function xsDetailOld()
    {
        return $this->hasOne('App\Models\XsDetail');
    }
    public function predict()
    {
        return $this->hasOne('App\Models\Predict');
    }
}