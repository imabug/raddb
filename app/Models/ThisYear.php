<?php

namespace App\Models;

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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function machine()
    {
        return $this->belongsTo(\App\Models\Machine::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(TestDate::class, 'id');
    }
}
