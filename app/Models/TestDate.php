<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TestDate extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testdates';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_date',
        'report_sent_date',
        'notes',
        'accession',
        'report_file_path',
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

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('survey_reports')
            ->useDisk('SurveyReports');
    }

    /*
     * Relationships
     */
    public function machine()
    {
        return $this->belongsTo('App\Models\Machine');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\TestType');
    }

    public function tester1()
    {
        return $this->belongsTo('App\Models\Tester');
    }

    public function tester2()
    {
        return $this->belongsTo('App\Models\Tester');
    }

    public function recommendations()
    {
        return $this->hasMany('App\Models\Recommendation', 'survey_id');
    }

    public function thisyear()
    {
        return $this->belongsTo('App\Models\ThisYear', 'survey_id');
    }

    public function lastyear()
    {
        return $this->belongsTo('App\Models\LastYear', 'survey_id');
    }

    /*
     * Scopes
     */

    /**
     * Scope function to return tests dates belonging to $machine_id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $machine_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForMachine($query, $machine_id)
    {
        // Scope function to return test dates belonging to $machine_id
        return $query->where('machine_id', $machine_id);
    }

    /**
     * Scope function to return test dates from the specified year.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $yr
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYear($query, $yr)
    {
        return $query->whereYear('test_date', '=', $yr);
    }

    /**
     * Scope function to return a specific $id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    /**
     * Scope function to return test dates for a specific type of test.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTestType($query, $id)
    {
        return $query->where('type_id', $id);
    }

    /**
     * Scope function to return pending test dates (scheduled after the current date).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('testdates.test_date', '>=', date('Y-m-d'));
    }

    /**
     * Scope function to return the n most recent routine annual survey test dates.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $n
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $n)
    {
        return $query->where('type_id', 1)
            ->orderby('test_date', 'desc')
            ->limit($n);
    }
}
