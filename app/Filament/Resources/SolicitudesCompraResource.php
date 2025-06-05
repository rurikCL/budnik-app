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
use Filament\Support\Enums\VerticalAlignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
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

                    Select::make('IDSolicitante')
                        ->relationship('solicitante', 'name'),

//                    TextInput::make('Comentario'),
                    TextInput::make('LugarDespacho'),

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

                /*Forms\Components\Section::make('Aprobadores')
                    ->schema([
                        Forms\Components\Repeater::make('Aprobaciones')
                            ->label('')
                            ->relationship('aprobaciones')
                            ->schema([
                                Forms\Components\ViewField::make('Foto')
                                    ->label('Aprobador')
                                    ->view('forms.components.user-avatar'),

                                Forms\Components\Select::make('Nivel')
                                    ->options([
                                        1, 2, 3, 4, 5, 6
                                    ])->distinct()
                                    ->grow(false),

//                                Forms\Components\Select::make('IDAprobador')
//                                    ->relationship('aprobador', 'name'),
                                Select::make('Estado')
                                    ->options([
                                        0 => 'Pendiente',
                                        1 => 'Aprobado',
                                        2 => 'Rechazado',
                                    ]),
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('Aprobar')
                                        ->form([
                                            Forms\Components\Fieldset::make('')
                                                ->schema([
                                                    TextInput::make('Comentario'),
                                                ])->columnSpanFull(),
                                        ])
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
                                ])->alignEnd()
                                    ->verticalAlignment(alignment: VerticalAlignment::End),


                            ])->columns(4)
                            ->deletable(false)
                    ])->headerActions([

                    ])*/
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
                    ->default(fn($record) => $record->articulos->sum('CostoTotal'))
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
                Tables\Actions\ViewAction::make(),
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
            RelationGroup::make('Relaciones', [
                RelationManagers\AprobacionesRelationManager::class,

                RelationManagers\ArticulosRelationManager::class,
            ]),

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolicitudesCompras::route('/'),
            'view' => Pages\ViewSolicitudesCompra::route('/{record}/view'),
            'create' => Pages\CreateSolicitudesCompra::route('/create'),
            'edit' => Pages\EditSolicitudesCompra::route('/{record}/edit'),
        ];
    }
}
