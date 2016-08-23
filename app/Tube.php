<?php
namespace RadDB;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tube extends Model
{

    /**
     * Attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
        'manuf_date',
        'install_date'
    ];

    protected $attributes = [
        'age'
    ];

    protected $appends = [
        'age'
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

    /*
     * Scopes
     */

    /**
     * Scope function to return tubes with tube_status = Active
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('tube_status', 'Active');
    }

    /**
     * Scope function to return tubes belonging to $machine_id
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $machine_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMachine($query, $machine_id)
    {
        return $query->where('machine_id', $machine_id);
    }

    /*
     * Mutators
     */

     /**
      * Add an age attribute based on either install or manufacture date
      *
      * @return int
      */
    public function getAgeAttribute()
    {
        // Calculate the age of the tube based on install_date or manuf_date
        if ($this->attributes['install_date'] != "0000-00-00") {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['install_date'])->age;
        } else
            if ($this->attributes['manuf_date'] != "0000-00-00") {
                return Carbon::createFromFormat('Y-m-d', $this->attributes['manuf_date'])->age;
            } else {
                return "N/A";
            }
    }

}
