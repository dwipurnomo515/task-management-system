<?php

namespace App\Filament\Widgets;

use Livewire\Component;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Task;



class TaskOverview extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getCards(): array
    {
        $userId = auth()->id();

        return [
            Card::make('Total', Task::where('assigned_to', $userId)->count()),
        ];
    }

    protected function getListeners(): array
    {
        return [
            'taskUpdated' => '$refresh',
            'taskCreated' => '$refresh',
        ];
    }
}
