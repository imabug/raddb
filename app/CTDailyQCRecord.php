<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CTDailyQCRecord extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ctdailyqc';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qcdate',
        'scan_type',
        'water_hu',
        'water_sd',
        'artifacts',
        'notes',
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
}
