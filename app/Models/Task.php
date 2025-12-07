<?php

namespace App\Models;

use App\Models\Builders\TaskBuilder;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'priority',
        'completed',
        'completed_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): TaskBuilder
    {
        return new TaskBuilder($query);
    }


    public function markComplete():void
    {
        $this->update([
           'completed' => true,
           'completed_at' => now(),
        ]);
    }



}
