<?php

namespace App\Models;

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
        return $this->belongsTo('App\Models\Machine', 'id');
    }

    public function prevSurvey()
    {
        return $this->belongsTo('App\Models\TestDate', 'prevSurveyID');
    }

    public function currSurvey()
    {
        return $this->belongsTo('App\Models\TestDate', 'currSurveyID');
    }
}
