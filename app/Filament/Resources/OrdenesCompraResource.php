<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenesCompraResource\Pages;
use App\Filament\Resources\OrdenesCompraResource\RelationManagers;
use App\Models\orden_compra;
use App\Models\OrdenesCompra;
use App\Models\solicitudes_compra;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdenesCompraResource extends Resource
{
    protected static ?string $model = orden_compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Ordenes de Compra';
    protected static ?string $label = 'Orden de Compra';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    TextInput::make('id')
                        ->label('Numero de Solicitud')
                        ->readOnly(),
                    Forms\Components\DatePicker::make('FechaSolicitud'),

                    TextInput::make('Descripcion'),

                    Select::make('IDSolicitante')
                        ->relationship('solicitante', 'name'),

                    Select::make('IDSolicitudCompra')
                        ->label('Solicitud de Compra')
                        ->options(solicitudes_compra::all()->pluck('Descripcion', 'id')->toArray()),

                    Forms\Components\ToggleButtons::make('Estado')
                        ->options([
                            '2' => 'Rechazado',
                            '0' => 'Pendiente',
                            '1' => 'Aprobado',
                        ])
                        ->colors([
                            '2' => 'danger',
                            '0' => 'info',
                            '1' => 'success',
                        ])
                        ->icons([
                            '2' => 'heroicon-o-x-mark',
                            '0' => 'heroicon-o-clock',
                            '1' => 'heroicon-o-check-circle',
                        ])
                        ->default(1)
                        ->inline()
                        ->grouped(),
                ])->columns(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),

                TextColumn::make('Descripcion')
                    ->searchable(),

                Tables\Columns\TextColumn::make('EstadoNombre')
                    ->label('Estado')
                    ->badge()
                    ->color(fn($state) => $state == 'Pendiente' ? 'info' : ($state == 'Aprobado' ? 'success' : 'danger'))
                    ->icon(fn($state) => $state == 'Aprobado' ? 'heroicon-s-check' : 'heroicon-o-clock'),

                TextColumn::make('solicitante.name')
                    ->label('Solicitante'),

                TextColumn::make('SumMonto')
                    ->label('Monto Total')
                    ->default(fn($record) => $record->solicitudCompra->articulos->sum('CostoTotal'))
                    ->money('CLP'),

                TextColumn::make('Presupuesto')
                    ->default(11000000)
                    ->money('CLP')
            ])
            ->filters([
                SelectFilter::make('Estado')->options([
                    0 => 'Pendiente',
                    1 => 'Aprobado',
                    2 => 'Rechazado',
                ]),
                SelectFilter::make('IDSolicitante')
//                    ->relationship('solicitante', 'name')
                    ->options(fn() => solicitudes_compra::all()
                        ->pluck('solicitante.name', 'solicitante.id'))
                    ->label('Solicitante'),
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AprobacionesRelationManager::class,
//            RelationGroup::make('Detalles', [
                RelationManagers\ArticulosRelationManager::class,
                RelationManagers\DocumentosRelationManager::class,

//            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdenesCompras::route('/'),
            'view' => Pages\ViewOrdenesCompra::route('/{record}/view'),
            'create' => Pages\CreateOrdenesCompra::route('/create'),
            'edit' => Pages\EditOrdenesCompra::route('/{record}/edit'),
        ];
    }
}
