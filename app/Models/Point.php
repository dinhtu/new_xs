<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $point
 * @property string $created_at
 * @property string $updated_at
 */
class Point extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'point';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['point', 'created_at', 'updated_at'];

}
