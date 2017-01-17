<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpNote extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['machine_id', 'note'];

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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'opnotes';

    // Relationships
    public function machine()
    {
        return $this->belongsTo('RadDB\Machine');
    }
}
