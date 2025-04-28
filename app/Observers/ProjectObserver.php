<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    public function creating(Project $project)
    {
        $project->created_by = auth()->id();
    }
} 