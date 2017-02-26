<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'machine_id',
        'photo_path',
    ];

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

    public function machine()
    {
        return $this->belongsTo('RadDB\Machine');
    }
}
