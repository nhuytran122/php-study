<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function salary_config()
    {
        return $this->hasOne(SalaryConfig::class);
    }
}