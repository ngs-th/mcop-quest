<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    protected $guarded = [];

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
