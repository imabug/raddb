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
    public function machine()
    {
        return $this->belongsTo('App\Models\Machine');
    }

    public function survey()
    {
        return $this->belongsTo(TestDate::class, 'id');
    }
}
