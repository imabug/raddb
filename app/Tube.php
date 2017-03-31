<?php

namespace RadDB;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tube extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'housing_model',
        'housing_sn',
        'insert_model',
        'insert_sn',
        'manuf_date',
        'install_date',
        'remove_date',
        'lfs',
        'mfs',
        'sfs',
        'notes',
        'tube_status',
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
        // 'manuf_date',
        // 'install_date'
    ];

    /*
     * Relationships
     */
    public function machine()
    {
        return $this->belongsTo('RadDB\Machine');
    }

    public function gendata()
    {
        return $this->hasMany('RadDB\Tube');
    }

    public function housing_manuf()
    {
        return $this->belongsTo('RadDB\Manufacturer');
    }

    public function insert_manuf()
    {
        return $this->belongsTo('RadDB\Manufacturer');
    }

    public function hvl()
    {
        return $this->belongsTo('RadDB\HVLData');
    }

    public function radSurveyData()
    {
        return $this->hasMany('RadDB\RadSurveyData');
    }

    public function collimatorData()
    {
        return$this->hasMany('RadDB\CollimatorData');
    }

    public function radiationOutput()
    {
        return $this->hasMany('RadDB\RadiationOutput');
    }

    public function fluoroData()
    {
        return $this->hasMany('RadDB\FluoroData');
    }

    public function maxFluoroData()
    {
        return $this->hasMany('RadDB\MaxFluoroData');
    }

    public function receptorEntranceExp()
    {
        return $this->hasMany('RadDB\ReceptorEntranceExp');
    }

    /*
     * Scopes
     */

    /**
     * Scope function to return tubes with tube_status = Active.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('tube_status', 'Active');
    }

    /**
     * Scope function to return tubes belonging to $machine_id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $machine_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForMachine($query, $machine_id)
    {
        return $query->where('machine_id', $machine_id);
    }

    /*
     * Mutators
     */

    /**
     * Add an age attribute based on either install or manufacture date.
     *
     * @return int
     */
    public function getAgeAttribute()
    {
        // Calculate the age of the tube based on install_date or manuf_date
        if ($this->attributes['install_date'] != '0000-00-00') {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['install_date'])->age;
        } elseif ($this->attributes['manuf_date'] != '0000-00-00') {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['manuf_date'])->age;
        } else {
            return 'N/A';
        }
    }
}
