<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
     * Attribute casting
     *
     * @var array<string, string>
     */
    proteted $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
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
        return $this->belongsTo(Machine::class);
    }

    public function type()
    {
        return $this->belongsTo(TestType::class);
    }

    public function tester1()
    {
        return $this->belongsTo(Tester::class);
    }

    public function tester2()
    {
        return $this->belongsTo(Tester::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'survey_id');
    }

    public function thisyear()
    {
        return $this->belongsTo(ThisYear::class, 'survey_id');
    }

    public function lastyear()
    {
        return $this->belongsTo(LastYear::class, 'survey_id');
    }

    public function genData()
    {
        return $this->hasMany(GenData::class);
    }

    public function leedsn3()
    {
        return $this->hasMany(LeedsN3::class);
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
    public function scopeForMachine($query, $machine_id): Builder
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
    public function scopeYear($query, $yr): Builder
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
    public function scopeId($query, $id): Builder
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
    public function scopeTestType($query, $id): Builder
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
    public function scopePending($query): Builder
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
    public function scopeRecent($query, $n): Builder
    {
        return $query->where('type_id', 1)
            ->orderby('test_date', 'desc')
            ->limit($n);
    }
}
