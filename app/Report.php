<?php

namespace RadDB;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    public function report()
    {
        return $this->morphTo();
    }
}
