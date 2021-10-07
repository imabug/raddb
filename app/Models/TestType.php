<?php

namespace RadDB\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestType extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['test_type'];

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
    protected $table = 'testtypes';

    // Relationships
    public function testdate()
    {
        return $this->hasMany('RadDB\Models\TestDate');
    }
}
