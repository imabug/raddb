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
     * Attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
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
