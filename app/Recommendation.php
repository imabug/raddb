<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Models\Media;

class Recommendation extends Model
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recommendation',
        'resolved',
        'rec_add_ts',
        'rec_resolve_ts',
        'resolved_by',
        'rec_status',
        'wo_number',
    ];

    /**
     * Attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'rec_add_ts',
        'rec_resolve_ts',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /*
     * Relationships
     */
    public function survey()
    {
        return $this->belongsTo('RadDB\TestDate');
    }

    /*
     * Scopes
     */

    /**
     * Scope function to return unresolved recommendations (resolved=0).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnresolved($query)
    {
        return $query->where('resolved', 0);
    }

    /**
     * Scope function to return unresolved recommendations (resolved=1).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeResolved($query)
    {
        return $query->where('resolved', 1);
    }

    /**
     * Scope function to return recommendations for a given $surveyID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $surveyID
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSurveyId($query, $surveyId)
    {
        return $query->where('survey_id', $surveyId);
    }
}
