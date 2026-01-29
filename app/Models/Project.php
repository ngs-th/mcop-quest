<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function systems()
    {
        return $this->hasMany(System::class);
    }

    public function bugs()
    {
        return $this->hasMany(Bug::class);
    }
}
