<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'status_id', 'order'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
