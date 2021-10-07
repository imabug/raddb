<?php

namespace RadDB\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modality extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modalities';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['modality'];

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
        return $this->hasMany('RadDB\Models\Machine');
    }
}
