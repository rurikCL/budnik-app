<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudesCompraResource\Pages;
use App\Filament\Resources\SolicitudesCompraResource\RelationManagers;
use App\Models\solicitudes_compra;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SolicitudesCompraResource extends Resource
{
    protected static ?string $model = solicitudes_compra::class;

    protected static ?string $navigationIcon = 'heroicon-s-rectangle-stack';
    protected static ?string $navigationLabel = 'Solicitudes de Compra';
    protected static ?string $label = 'Solicitud de Compra';
    protected static ?int $navigationSort = 1;


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
//                    TextInput::make('Comentario'),
                    TextInput::make('LugarDespacho'),
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

                ])

                /*Forms\Components\Repeater::make('Articulos')
                    ->relationship('articulos')
                    ->schema([
                        TextInput::make('Descripcion'),
                        TextInput::make('DescUnidad')
                            ->label('U/M'),
                        TextInput::make('Cantidad')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, $get, $set, $record) => $set('CostoTotal', $get('CostoUnitario') * $state))
                            ->grow(false),
                        TextInput::make('CostoUnitario')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, $get, $set, $record) => $set('CostoTotal', $get('Cantidad') * $state)),
                        TextInput::make('CostoTotal')
                            ->reactive()
                            ->readOnly(),
                        Select::make('CuentaContable')->options([
                            1 => '391144554',
                            2 => '391155433'
                        ]),
                        Select::make('UnidadNegocio')->options([
                            99, 101, 103
                        ])

                    ])->columns(7)
                    ->columnSpanFull(),*/


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
                    ->label('Estado'),

                TextColumn::make('solicitante.name')
                    ->label('Solicitante'),

                TextColumn::make('SumMonto')
                    ->label('Monto Total')
                    ->default(fn($record) => $record->articulos->sum('CostoTotal'))
                    ->money('CLP'),

                TextColumn::make('Presupuesto')
                    ->default(11000000)
                    ->money('CLP')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ver'),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('Relaciones', [
                RelationManagers\ArticulosRelationManager::class,
                RelationManagers\AprobacionesRelationManager::class
            ]),

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolicitudesCompras::route('/'),
            'create' => Pages\CreateSolicitudesCompra::route('/create'),
            'edit' => Pages\EditSolicitudesCompra::route('/{record}/edit'),
        ];
    }
}
