<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class LeedsN3 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leeds_n3';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_size',
        'n3',
    ];

    /**
     * Attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /*
     * Relationships
     */
     public function machine()
     {
         return $this->belongsTo('RadDB\Machine');
     }

     public function survey()
     {
         return $this->belongsTo('RadDB\TestDate');
     }

     public function tube()
     {
         return $this->belongsTo('RadDB\Tube');
     }
}
