<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryConfig extends Model
{
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}