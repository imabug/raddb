<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // Relationships
    public function machine()
    {
        return $this->hasMany('RadDB\Machine');
    }

    public function contact()
    {
        return $this->hasMany('RadDB\Contact');
    }
}
