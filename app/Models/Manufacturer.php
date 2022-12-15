<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['manufacturer'];

    /**
     * Attribute casting
     *
     * @var array<string, string>
     */
    proteted $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function machine()
    {
        return $this->hasMany(Machine::class);
    }

    public function tube_housing_manuf()
    {
        return $this->hasMany(Tube::class);
    }

    public function tube_ins_manuf()
    {
        return $this->hasMany(Tube::class);
    }
}
