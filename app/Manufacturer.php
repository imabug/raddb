<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    // Relationships
    public function machine()
    {
        return $this->hasMany('RadDB\Machine');
    }

    public function tube_housing_manuf()
    {
        return $this->hasMany('RadDB\Tube');
    }

    public function tube_ins_manuf()
    {
        return $this->hasMany('RadDB\Tube');
    }
}
