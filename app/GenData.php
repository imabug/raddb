<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class GenData extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gendata';

    // Relationships
    public function tube()
    {
        return $this->belongsTo('RadDB\Tube');
    }
}
