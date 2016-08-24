<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class TestDate extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testdates';

    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'machine_id',
        'test_date',
        'report_sent_date',
        'tester1_id',
        'tester2_id',
        'type_id',
        'notes',
        'accession',
        'report_file_path'
    ];

    /**
     * Attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = [
        'test_date',
        'report_sent_date',
        'deleted_at',
        'created_at',
        'updated_at'
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

    /*
     * Scopes
     */

    /**
     * Scope function to return tests dates belonging to $machine_id
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $machine_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMachine($query, $machine_id)
    {
        // Scope function to return test dates belonging to $machine_id
        return $query->where('machine_id', $machine_id);
    }

    /**
     * Scope function to return test dates from the specified year
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $yr
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYear($query, $yr)
    {
        return $query->whereYear('test_date', '=', $yr);
    }
}
