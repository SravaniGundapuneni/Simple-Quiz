<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
