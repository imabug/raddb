<?php

namespace RadDB\Models;

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
    ];

    /*
     * Relationships
     */
    public function machine()
    {
        return $this->belongsTo('RadDB\Models\Machine');
    }

    public function housing_manuf()
    {
        return $this->belongsTo('RadDB\Models\Manufacturer');
    }

    public function insert_manuf()
    {
        return $this->belongsTo('RadDB\Models\Manufacturer');
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
        if (! is_null($this->attributes['install_date'])) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['install_date'])->age;
        } elseif (! is_null($this->attributes['manuf_date'])) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['manuf_date'])->age;
        } else {
            return 'N/A';
        }
    }
}
