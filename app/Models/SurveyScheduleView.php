<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    // public function machine(): BelongsTo
    // {
    //     return $this->belongsTo(Machine::class, 'id');
    // }

    public function prevSurvey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class, 'prevSurveyID');
    }

    public function currSurvey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class, 'currSurveyID');
    }
}
