<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Manajemen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'todo' => 'To Do',
                        'in_progress' => 'In Progress',
                        'done' => 'Done',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('deadline')
                    ->required(),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignee', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'todo' => 'warning',
                        'in_progress' => 'primary',
                        'done' => 'success',
                        default => 'gray',
                    })
                    ->label('Status'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->hasPermissionTo('delete_task')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->hasPermissionTo('delete_any_task')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'view' => Pages\ViewTask::route('/{record}'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!auth()->user()->hasRole('super-admin')) {
            $query->where('assigned_to', auth()->id());
        }

        return $query;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermissionTo('view_any_task');
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('view_task');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('create_task');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('update_task');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('delete_task');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->hasPermissionTo('delete_any_task');
    }
}
