<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class TaskOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $projects = Project::withCount([
            'tasks as todo_count' => function ($query) {
                $query->where('status', 'todo');
            },
            'tasks as in_progress_count' => function ($query) {
                $query->where('status', 'in_progress');
            },
            'tasks as done_count' => function ($query) {
                $query->where('status', 'done');
            },
            'tasks as overdue_count' => function ($query) {
                $query->where('deadline', '<', Carbon::today())
                    ->whereIn('status', ['todo', 'in_progress']);
            },
            'tasks as upcoming_count' => function ($query) {
                $query->whereBetween('deadline', [Carbon::today(), Carbon::today()->addDays(7)])
                    ->whereIn('status', ['todo', 'in_progress']);
            },
        ])->get();

        $users = User::withCount([
            'assignedTasks as todo_count' => function ($query) {
                $query->where('status', 'todo');
            },
            'assignedTasks as in_progress_count' => function ($query) {
                $query->where('status', 'in_progress');
            },
            'assignedTasks as done_count' => function ($query) {
                $query->where('status', 'done');
            },
            'assignedTasks as overdue_count' => function ($query) {
                $query->where('deadline', '<', Carbon::today())
                    ->whereIn('status', ['todo', 'in_progress']);
            },
            'assignedTasks as upcoming_count' => function ($query) {
                $query->whereBetween('deadline', [Carbon::today(), Carbon::today()->addDays(7)])
                    ->whereIn('status', ['todo', 'in_progress']);
            },
        ])->get();

        $totalTasks = $projects->sum(function ($project) {
            return $project->todo_count + $project->in_progress_count + $project->done_count;
        });

        $totalOverdue = $projects->sum('overdue_count');
        $totalUpcoming = $projects->sum('upcoming_count');

        return [
            Stat::make('Total Tasks', $totalTasks)
                ->description('Across all projects and users')
                ->color('gray'),
            Stat::make('Overdue Tasks', $totalOverdue)
                ->description('Tasks past deadline')
                ->color('danger'),
            Stat::make('Upcoming Tasks', $totalUpcoming)
                ->description('Due in next 7 days')
                ->color('warning'),
        ];
    }
} 