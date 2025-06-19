<?php

namespace App\Filament\Resources\SolicitudesCompraResource\RelationManagers;

use Faker\Provider\Text;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AprobacionesRelationManager extends RelationManager
{
    protected static string $relationship = 'aprobaciones';
    protected static ?string $modelLabel = 'Aprobacion';
    protected static ?string $pluralLabel = 'Aprobaciones';

    protected $listeners = ['refreshRelation' => 'refresh'];


    public function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\ViewField::make('Foto')
//                    ->label('Aprobador')
//                    ->view('forms.components.user-avatar'),

                Forms\Components\Select::make('Nivel')
                    ->options([
                        1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5
                    ])->distinct()
                    ->default(1)
                    ->grow(false),

                Forms\Components\Select::make('IDAprobador')
                    ->relationship('aprobador', 'name'),

                Forms\Components\Select::make('Estado')
                    ->options([
                        0 => 'Pendiente',
                        1 => 'Aprobado',
                        2 => 'Rechazado',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Aprobaciones')
            ->columns([
                Tables\Columns\ImageColumn::make('aprobador.Foto')
                    ->label('Avatar')
                    ->circular(),
                TextColumn::make('aprobador.name'),
                TextColumn::make('Nivel'),
                TextColumn::make('EstadoNombre')
                    ->label('Estado')
                    ->badge()
                    ->color(fn($record) => $record->EstadoColor)
                    ->icon(fn($record) => $record->EstadoIcono),
                TextColumn::make('updated_at')
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
