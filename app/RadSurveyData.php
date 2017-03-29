<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RadSurveyData extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'radsurveydata';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sid_accuracy_error',
        'avg_illumination',
        'beam_alignment_error',
        'rad_film_center_table',
        'rad_film_center_wall',
        'lfs_resolution',
        'sfs_resolution',
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
