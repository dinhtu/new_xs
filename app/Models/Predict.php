<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $day
 * @property string $detail
 * @property string $created_at
 * @property string $updated_at
 */
class Predict extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'predict';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['day', 'detail', 'created_at', 'updated_at'];

}
