<?php
namespace RadDB;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use SoftDeletes;
    
    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'modality_id',
        'description',
        'manufacturer_id',
        'vend_site_id',
        'model',
        'serial_number',
        'manuf_date',
        'install_date',
        'remove_date',
        'location_id',
        'room',
        'status',
        'notes',
        'photo'
    ];

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
    public function location()
    {
        return $this->belongsTo('RadDB\Location');
    }

    public function modality()
    {
        return $this->belongsTo('RadDB\Modality');
    }

    public function manufacturer()
    {
        return $this->belongsTo('RadDB\Manufacturer');
    }

    public function tube()
    {
        return $this->hasMany('RadDB\Tube');
    }

    public function opnote()
    {
        return $this->hasMany('RadDB\OpNote');
    }

    public function testdate()
    {
        return $this->hasMany('RadDB\TestDate');
    }

    public function recommendation()
    {
        return $this->hasManyThrough('RadDB\Recommendation', 'RadDB\TestDate', 'machine_id', 'survey_id');
    }

    public function gendata()
    {
        return $this->hasManyThrough('RadDB\GenData', 'RadDB\TestDate', 'machine_id', 'survey_id');
    }

    /*
     * Scopes
     */

    /**
     * Scope function to return active machines
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('machine_status', 'Active');
    }

    /**
     * Scope function to return machines for a specific location
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLocation($query, $id)
    {
        // Scope function to return machines with location_id=$id
        return $query->where('location_id', $id);
    }

    /**
     * Scope function to return machines for a specific modality
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeModality($query, $id)
    {
        // Scope function to return machines with modality_id=$id
        return $query->where('modality_id', $id);
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
        // Calculate the age of the unit based on install_date or manuf_date
        if ($this->attributes['install_date'] != "0000-00-00") {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['install_date'])->age;
        } elseif ($this->attributes['manuf_date'] != "0000-00-00") {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['manuf_date'])->age;
        } else {
            return "N/A";
        }
    }
}
