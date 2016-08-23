<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class Tester extends Model
{
    // Relationships
    public function testdate()
    {
        return $this->hasMany('RadDB\TestDate');
    }
}
