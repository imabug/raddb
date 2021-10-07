<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Relationships
    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }
}
