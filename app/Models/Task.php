<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function flow()
    {
        return $this->belongsTo(Flow::class);
    }
}
