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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
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
                    Select::make('Estado')->options([
                        0 => 'Pendiente',
                        1 => 'Aprobado',
                        2 => 'Rechazado',
                    ])->default(0),

                    Select::make('IDSolicitudCompra')->options(solicitudes_compra::all()->pluck('Descripcion', 'id')->toArray()),

//                    TextInput::make('Comentario'),
                    Select::make('IDSolicitante')
                        ->relationship('solicitante', 'name')
                ])->columns(),

                Forms\Components\Section::make([
                    Forms\Components\Textarea::make('Comentario'),
                    Forms\Components\Actions::make([
                        Forms\Components\Actions\Action::make('Aprobar')
                            ->button()
                            ->color('success')
                            ->requiresConfirmation()
                            ->modalHeading('Aprobar Solicitud')
                            ->modalDescription('Esta seguro que desea aprobar esta solicitud?'),
                        Forms\Components\Actions\Action::make('Rechazar')
                            ->button()
                            ->color('danger')
                            ->requiresConfirmation()
                            ->modalHeading('Rechazar Solicitud')
                            ->modalDescription('Esta seguro que desea rechazar esta solicitud?'),
                    ])->grow(false)
                        ->alignRight(),

                ])]);
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
                    ->label('Estado'),

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
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdenesCompras::route('/'),
            'create' => Pages\CreateOrdenesCompra::route('/create'),
            'edit' => Pages\EditOrdenesCompra::route('/{record}/edit'),
        ];
    }
}
