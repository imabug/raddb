<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Relationships
    public function location()
    {
        return $this->belongsTo('RadDB\Location');
    }
}
