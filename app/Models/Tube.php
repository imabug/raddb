<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tube extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
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
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'   => 'datetime',
        'deleted_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'install_date' => 'datetime:Y-m-d',
        'remove_date'  => 'datetime:Y-m-d',
    ];

    /**
     * Accessors to append to the model.
     *
     * @var array<string>
     */
    protected $appends = ['age'];

    /*
     * Relationships
     */
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function housing_manuf(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function insert_manuf(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
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
     * Scope function to return tubes with tube_status = Active.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeActive($query): Builder
    {
        return $query->where('tube_status', 'Active');
    }

    /**
     * Scope function to return tubes belonging to $machine_id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $machine_id
     */
    public function scopeForMachine($query, $machine_id): Builder
    {
        return $query->where('machine_id', $machine_id);
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
