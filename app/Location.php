<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location'];

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
        return $this->hasMany('RadDB\Machine');
    }

    public function contact()
    {
        return $this->hasMany('RadDB\Contact');
    }
}
