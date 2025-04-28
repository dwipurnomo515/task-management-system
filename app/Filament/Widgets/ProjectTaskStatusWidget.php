<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ProjectTaskStatusWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';
    protected static ?string $heading = 'Project Task Status';
    protected int|string|array $columnSpan = 'full';

    public function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->query(
                Project::query()
                    ->withCount([
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
                    ])
            )
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('todo_count')
                    ->label('To Do')
                    ->color('warning')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('in_progress_count')
                    ->label('In Progress')
                    ->color('primary')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('done_count')
                    ->label('Done')
                    ->color('success')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('overdue_count')
                    ->label('Overdue')
                    ->color('danger')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('upcoming_count')
                    ->label('Upcoming (7 days)')
                    ->color('warning')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_tasks')
                    ->label('Total')
                    ->state(function ($record) {
                        return $record->todo_count + $record->in_progress_count + $record->done_count;
                    })
                    ->sortable(),
            ])
            ->defaultSort('name', 'asc')
            ->paginated(false);
    }
} 