<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testtypes';

    // Relationships
    public function testdate()
    {
        return $this->hasMany('RadDB\TestDate');
    }
}
