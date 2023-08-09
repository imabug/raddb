<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Machine::class);
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class, 'id');
    }
}
