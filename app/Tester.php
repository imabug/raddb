<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tester extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = ['name', 'initials'];

    /**
     * Attributes that should be mutated to dates
     *
     * @var array
     */

     protected $dates = [
         'created_at',
         'deleted_at',
         'updated_at',
     ];

    // Relationships
    public function testdate()
    {
        return $this->hasMany('RadDB\TestDate');
    }
}
