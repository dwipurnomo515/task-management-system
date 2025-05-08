<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Filament\Widgets\TaskOverview;
use App\Filament\Widgets\TaskTodoWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    public function getTitle(): string
    {
        return 'Tasks';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function () {
                    $this->dispatch('taskUpdated');
                }),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
            TaskOverview::class,
            TaskTodoWidget::class,
        ];
    }

    public function getTableHeading(): ?string
    {
        return 'Task Todo';
    }

    public function getListeners(): array
    {
        return [
            'taskUpdated' => '$refresh',
        ];
    }
}
