<?php

namespace RadDB\Models;

use Illuminate\Database\Eloquent\Model;

class ThisYear extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'thisyear_view';

    /*
     * Relationships
     */
    public function machine()
    {
        return $this->belongsTo('RadDB\Models\Machine');
    }

    public function survey()
    {
        return $this->belongsTo('RadDB\Models\TestDate', 'id');
    }
}
