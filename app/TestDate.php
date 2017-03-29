<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestDate extends Model
{
    use SoftDeletes;

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
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        // 'test_date',
        // 'report_sent_date',
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

    public function type()
    {
        return $this->belongsTo('RadDB\TestType');
    }

    public function tester1()
    {
        return $this->belongsTo('RadDB\Tester');
    }

    public function tester2()
    {
        return $this->belongsTo('RadDB\Tester');
    }

    public function recommendations()
    {
        return $this->hasMany('RadDB\Recommendation', 'survey_id');
    }

    public function thisyear()
    {
        return $this->belongsTo('RadDB\ThisYear', 'survey_id');
    }

    public function lastyear()
    {
        return $this->belongsTo('RadDB\LastYear', 'survey_id');
    }

    public function gendata()
    {
        return $this->hasMany('RadDB\GenData', 'survey_id');
    }

    public function hvl()
    {
        return $this->hasMany('RadDB\HVLData', 'survey_id');
    }

    public function radSurveyData()
    {
        return $this->hasMany('RadDB\RadSurveyData', 'survey_id');
    }
    public function collimatorData()
    {
        return $this->hasMany('RadDB\CollimatorData', 'survey_id');
    }

    public function radiationOutput()
    {
        return $this->hasMany('\RadDB\RadiationOutput', 'survey_id');
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
      * @param int id
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
      * @param int $yr
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
}
