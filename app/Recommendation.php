<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'survey_id',
        'recommendation',
        'resolved',
        'rec_add_ts',
        'rec_resolve_ts',
        'resolved_by',
        'rec_status',
        'wo_number',
        'service_report_path'
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
     * Scope function to return unresolved recommendations (resolved=0)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnresolved($query)
    {
        return $query->where('resolved', 0);
    }
}
