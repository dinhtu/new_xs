<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $day
 * @property int $total
 * @property string $created_at
 * @property string $updated_at
 */
class Result extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'result';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['day', 'total', 'created_at', 'updated_at'];

}
