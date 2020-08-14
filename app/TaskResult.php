<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskResult extends Model
{
    protected $fillable = [
        'post_key',
        'result_url',
        'result_title',
        'loc_id',
    ];

    public function task()
    {
      return $this->belongsTo(Task::class);
    }
}
