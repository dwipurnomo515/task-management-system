<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;

class TaskTodoWidget extends BaseWidget
{
    protected static ?string $heading = 'Task Todo';
    protected int|string|array $columnSpan = 'full';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Task::query()
                    ->where('assigned_to', auth()->id())
                    ->where('status', 'todo')
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Title')->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function () {
                        $this->dispatch('taskUpdated');
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function () {
                        $this->dispatch('taskUpdated');
                    }),
            ]);
    }
}
