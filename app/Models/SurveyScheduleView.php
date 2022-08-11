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
        return $this->belongsTo(Machine::class, 'id');
    }

    public function prevSurvey()
    {
        return $this->belongsTo(TestDate::class, 'prevSurveyID');
    }

    public function currSurvey()
    {
        return $this->belongsTo(TestDate::class, 'currSurveyID');
    }
}
