<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class SurveyScheduleView extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surveyschedule_view';

    /*
     * Relationships
     */
    public function machine()
    {
        return $this->belongsTo('RadDB\Machine', 'id');
    }

    public function prev_survey()
    {
        return $this->belongsTo('RadDB\TestDate');
    }

    public function curr_survey()
    {
        return $this->belongsTo('RadDB\TestDate');
    }
}
