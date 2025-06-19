<?php

namespace App\Filament\Resources\SolicitudesCompraResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\ContentTabPosition;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticulosRelationManager extends RelationManager
{
    protected static string $relationship = 'detalle';
    protected static ?string $modelLabel = 'Articulo';
    protected static ?string $pluralLabel = 'Articulos';

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public function getContentTabPosition(): ?ContentTabPosition
    {
        return ContentTabPosition::Before;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Descripcion'),
                Select::make('DescUnidad')
                    ->label('U/M')
                    ->options([
                        'MT2' => 'MT2',
                        'Unidad' => 'Unidad',
                    ]),

                Forms\Components\Fieldset::make()
                    ->schema([
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
                    ])->columns(3),


                Forms\Components\Section::make([
                    Select::make('CuentaContable')->options([
                        1 => '391144554',
                        2 => '391155433'
                    ]),
                    Select::make('UnidadNegocio')->options([
                        99, 101, 103
                    ]),
                    Select::make('CentroCosto')
                        ->label('Centro')
                        ->options([
                            00154, 00141
                        ])->grow(false),
                    Select::make('LugarFisico')
                        ->label('Lugar fisico')
                        ->options([
                            001, 002
                        ])->grow(false),
                    Select::make('SubCentro')
                        ->label('Sub centro')
                        ->options([
                            1201, 1202
                        ])->grow(false),
                ])->columns(3)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Articulos')
            ->description('Linea de artículos por orden de inserción')
            ->columns([
                Tables\Columns\TextColumn::make('LineNumber')
                ->label('Linea')
                ->grow(false),

                Tables\Columns\TextColumn::make('ITEMNMBR')
                ->label('Item'),

                Tables\Columns\TextColumn::make('ITEMDESC')
                ->label('Desc'),

                TextColumn::make('QTYORDER')
                    ->label('Cantidad'),

                TextColumn::make('UOFM')
                ->label('Tipo unidad'),

                TextColumn::make('QTYUNCMTBASE'),
                TextColumn::make('UNITCOST'),


                /*
                Tables\Columns\TextColumn::make('DescUnidad')
                    ->label('U/M'),
                Tables\Columns\TextColumn::make('Cantidad')
                    ->grow(false),
                Tables\Columns\TextColumn::make('CostoUnitario'),
                Tables\Columns\TextColumn::make('CostoTotal')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->prefix('$')
                            ->money('CLP')
                            ->label('Total')
                    ]),
                Tables\Columns\SelectColumn::make('CuentaContable')
                    ->label('Cta. contable')
                    ->options([
                        1 => '391144554',
                        2 => '391155433'
                    ])->grow(false),
                Tables\Columns\SelectColumn::make('UnidadNegocio')
                    ->label('U. Negocio')
                    ->options([
                        99, 101, 103
                    ])->grow(false),
                Tables\Columns\SelectColumn::make('CentroCosto')
                    ->label('Centro')
                    ->options([
                        00154, 00141
                    ])->grow(false),
                Tables\Columns\SelectColumn::make('LugarFisico')
                    ->label('Lugar fisico')
                    ->options([
                        001, 002
                    ])->grow(false),
                Tables\Columns\SelectColumn::make('SubCentro')
                    ->label('Sub centro')
                    ->options([
                        1201, 1202
                    ])->grow(false),*/

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Agregar Articulo')
                    ->icon('heroicon-o-plus')
                    ->size('xs'),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('LineNumber',  'asc');
    }
}
