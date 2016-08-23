<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class OpNote extends Model
{

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
