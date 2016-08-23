<?php
namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class Modality extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modalities';

    // Relationships
    public function machine()
    {
        return $this->hasMany('RadDB\Machine');
    }
}
