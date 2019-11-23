<?php

namespace RadDB;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Machine extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'vend_site_id',
        'model',
        'serial_number',
        'manuf_date',
        'install_date',
        'remove_date',
        'room',
        'status',
        'notes',
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

    public function thisyear()
    {
        return $this->hasMany('RadDB\ThisYear');
    }

    public function lastyear()
    {
        return $this->hasMany('RadDB\LastYear');
    }

    public function testdateRecent()
    {
        return $this->hasMany('RadDB\TestDate')->latest('test_date')->first();
    }

    public function recommendation()
    {
        return $this->hasManyThrough('RadDB\Recommendation', 'RadDB\TestDate', 'machine_id', 'survey_id');
    }

    public function gendata()
    {
        return $this->hasManyThrough('RadDB\GenData', 'RadDB\TestDate', 'machine_id', 'survey_id');
    }

    public function surveySchedule()
    {
        return $this->hasOne('RadDB\SurveyScheduleView', 'id');
    }

    /*
     * Scopes
     */

    /**
     * Scope function to return active machines.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('machine_status', 'Active');
    }

    /**
     * Scope function to return inactive machines.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('machine_status', 'Inactive');
    }

    /**
     * Scope function to return removed machines.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRemoved($query)
    {
        return $query->where('machine_status', 'Removed');
    }

    /**
     * Scope function to return machines for a specific location.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLocation($query, $id)
    {
        // Scope function to return machines with location_id=$id
        return $query->where('location_id', $id);
    }

    /**
     * Scope function to return machines for a specific modality.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeModality($query, $id)
    {
        // Scope function to return machines with modality_id=$id
        return $query->where('modality_id', $id);
    }

    /**
     * Scope function to return machines for a specific manufacturer.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManufacturer($query, $id)
    {
        // Scope function to return machines with modality_id=$id
        return $query->where('manufacturer_id', $id);
    }

    /**
     * Scope function to return test equipment.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeTestEquipment($query)
    {
        // If the modality_id for test equipment is something other than 19
        // change the value in the where() clause.
        return $query->where('modality_id', 19);
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
        // Calculate the age of the unit based on manuf_date or install_date
        if (! is_null($this->attributes['manuf_date'])) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['manuf_date'])->age;
        } elseif (! is_null($this->attributes['install_date'])) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['install_date'])->age;
        } else {
            return 'N/A';
        }
    }
}
