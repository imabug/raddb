<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollimatorData extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collimatordata';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receptor',
        'table_sid',
        'wall_sid',
        'indicated_trans',
        'indicated_long',
        'rad_trans',
        'rad_long',
        'light_trans',
        'light_long',
        'pbl_trans',
        'pbl_long',
    ];

    /**
     * Attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /*
     * Relationships
     */
     public function machine()
     {
         return $this->belongsTo('RadDB\Machine');
     }

     public function survey()
     {
         return $this->belongsTo('RadDB\TestDate');
     }

     public function tube()
     {
         return $this->belongsTo('RadDB\Tube');
     }
}
