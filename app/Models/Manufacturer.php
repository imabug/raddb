<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['manufacturer'];

    /**
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function machine(): HasMany
    {
        return $this->hasMany(Machine::class);
    }

    public function tube_housing_manuf(): HasMany
    {
        return $this->hasMany(Tube::class);
    }

    public function tube_ins_manuf(): HasMany
    {
        return $this->hasMany(Tube::class);
    }
}
