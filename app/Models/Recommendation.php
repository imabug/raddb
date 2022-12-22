<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class Recommendation extends Model
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
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
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'     => 'datetime',
        'deleted_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'rec_add_ts'     => 'datetime',
        'rec_resolve_ts' => 'datetime',
    ];

    public function registerMediaCollection(): void
    {
        $this->addMediaCollection('service_reports')
            ->useDisk('ServiceReports');
    }

    /*
     * Relationships
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(TestDate::class);
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
    public function scopeUnresolved($query): Builder
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
    public function scopeResolved($query): Builder
    {
        return $query->where('resolved', 1);
    }

    /**
     * Scope function to return recommendations for a given $surveyID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $surveyId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSurveyId($query, $surveyId): Builder
    {
        return $query->where('survey_id', $surveyId);
    }
}
