<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenData extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gendata';

    /*
     * Relationships
     */
    public function survey()
    {
        return $this->belongsTo(TestDate::class);
    }

    public function tube()
    {
        return $this->belongsTo(Tube::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}