<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AprobadoresOrdenCompraResource\Pages;
use App\Filament\Resources\AprobadoresOrdenCompraResource\RelationManagers;
use App\Models\aprobadores_solicitud;
use App\Models\AprobadoresOrdenCompra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AprobadoresOrdenCompraResource extends Resource
{
    protected static ?string $model = aprobadores_solicitud::class;

    protected static ?string $navigationGroup = 'Administracion';
    protected static ?string $navigationLabel = 'Aprobadores Ordenes Compra ';
    protected static ?string $label = 'Aprobador';
    protected static ?string $pluralLabel = 'Aprobadores';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('Nivel')
                    ->options([
                        1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5
                    ])->distinct()
                    ->default(1)
                    ->grow(false),

                Forms\Components\Select::make('IDAprobador')
                    ->relationship('aprobador', 'name'),

                Forms\Components\Select::make('IDReemplazo')
                    ->relationship('reemplazo', 'name'),

                Forms\Components\ToggleButtons::make('Activo')
                    ->options([
                        '0' => 'Inactivo',
                        '1' => 'Activo',
                        '2' => 'Reemplazo',
                    ])
                    ->colors([
                        '0' => 'danger',
                        '1' => 'success',
                        '2' => 'warning',
                    ])
                    ->default(1)
                    ->inline()
                    ->grouped(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query->where('idSolicitudTipo', 2);
            })
            ->columns([
                TextColumn::make('aprobador.name'),
                TextColumn::make('reemplazo.name'),
                TextColumn::make('ActivoNombre')
                    ->label('Estado Activo')
                    ->badge()
                    ->color(fn($record)=>$record->ActivoColor)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAprobadoresOrdenCompras::route('/'),
            'create' => Pages\CreateAprobadoresOrdenCompra::route('/create'),
            'edit' => Pages\EditAprobadoresOrdenCompra::route('/{record}/edit'),
        ];
    }
}
