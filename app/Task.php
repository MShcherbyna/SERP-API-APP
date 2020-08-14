<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task_id',
        'status',
    ];

    public function results()
    {
      return $this->hasMany(TaskResult::class);
    }
}
