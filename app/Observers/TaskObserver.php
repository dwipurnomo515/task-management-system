<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    public function creating(Task $task)
    {
        $task->created_by = auth()->id();
    }
} 