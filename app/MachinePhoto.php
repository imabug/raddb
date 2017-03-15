<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachinePhoto extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'machinephotos';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'machine_id',
        'machine_photo',
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

    /*
     * Scopes
     */

    /**
     * Scope function to return photos for machine $id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMachine($query, $id)
    {
        return $query->where('machine_id', $id);
    }
}
