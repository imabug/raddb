<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenData extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kv_set',
        'ma_set',
        'time_set',
        'mas_set',
        'add_filt',
        'distance',
        'kv_avg',
        'kv_max',
        'kv_eff',
        'exp_time',
        'exposure',
        'use_flags',
    ];

    /**
     * Attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
     'created_at',
     'deleted_at',
     'updated_at',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gendata';

    // Relationships
    public function tube()
    {
        return $this->belongsTo('RadDB\Tube');
    }

    public function survey()
    {
        return $this->belongsTo('RadDB\TestDate');
    }

    /*
     * Scopes
     */

    /*
     * Scope function to return generator data for a survey ID
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSurveyId($query, $surveyId)
    {
        return $query->where('survey_id', $surveyId);
    }
}
