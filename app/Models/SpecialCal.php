<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $day
 * @property int $cal
 * @property string $created_at
 * @property string $updated_at
 */
class SpecialCal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'special_cal';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['day', 'cal', 'created_at', 'updated_at'];

}
