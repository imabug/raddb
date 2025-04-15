<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Machine extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
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
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'   => 'datetime',
        'deleted_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'manuf_date'   => 'date:Y-m-d',
        'install_date' => 'date:Y-m-d',
    ];

    /**
     * Accessors to append to the model.
     *
     * @var array<string>
     */
    protected $appends = ['age'];

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaCollection('machine_photos')
            ->useDisk('MachinePhotos');
    }

    /*
     * Relationships
     */

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function modality(): BelongsTo
    {
        return $this->belongsTo(Modality::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function tube(): HasMany
    {
        return $this->hasMany(Tube::class);
    }

    public function opnote(): HasMany
    {
        return $this->hasMany(OpNote::class);
    }

    public function testdate(): HasMany
    {
        return $this->hasMany(TestDate::class);
    }

    public function thisyear(): HasMany
    {
        return $this->hasMany(ThisYear::class);
    }

    public function lastyear(): HasMany
    {
        return $this->hasMany(LastYear::class);
    }

    public function testdateRecent(): HasMany
    {
        return $this->hasMany(TestDate::class)
            ->latest('test_date')->first();
    }

    public function recommendation(): HasManyThrough
    {
        return $this->hasManyThrough(
            Recommendation::class,
            TestDate::class,
            'machine_id',
            'survey_id'
        );
    }

    public function surveySchedule(): HasOne
    {
        return $this->hasOne(SurveyScheduleView::class, 'id');
    }

    public function genData(): HasMany
    {
        return $this->hasMany(GenData::class);
    }

    public function leedsn3(): HasMany
    {
        return $this->hasMany(LeedsN3::class);
    }
    /*
     * Scopes
     */

    /**
     * Scope function to return active machines.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeActive($query): Builder
    {
        return $query->where('machine_status', 'Active');
    }

    /**
     * Scope function to return inactive machines.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeInactive($query): Builder
    {
        return $query->where('machine_status', 'Inactive');
    }

    /**
     * Scope function to return removed machines.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeRemoved($query): Builder
    {
        return $query->where('machine_status', 'Removed');
    }

    /**
     * Scope function to return machines for a specific location.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     */
    public function scopeLocation($query, $id): Builder
    {
        // Scope function to return machines with location_id=$id
        return $query->where('location_id', $id);
    }

    /**
     * Scope function to return machines for a specific modality.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     */
    public function scopeModality($query, $id): Builder
    {
        // Scope function to return machines with modality_id=$id
        return $query->where('modality_id', $id);
    }

    /**
     * Scope function to return machines for a specific manufacturer.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     */
    public function scopeManufacturer($query, $id): Builder
    {
        // Scope function to return machines with modality_id=$id
        return $query->where('manufacturer_id', $id);
    }

    /**
     * Scope function to return test equipment.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeTestEquipment($query): Builder
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
     */
    public function age(): Attribute
    {
        // Calculate the age of the unit based on manuf_date or install_date
        return Attribute::make(
            get: function ($value, $attributes) {
                if (!is_null($attributes['manuf_date'])) {
                    return Carbon::createFromFormat('Y-m-d', $attributes['manuf_date'])->age;
                } elseif (!is_null($attributes['install_date'])) {
                    return Carbon::createFromFormat('Y-m-d', $attributes['install_date'])->age;
                }
            }
        );
    }
}
