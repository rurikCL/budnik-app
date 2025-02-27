<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacturacionResource\Pages;
use App\Filament\Resources\FacturacionResource\RelationManagers;
use App\Models\Facturacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacturacionResource extends Resource
{
    protected static ?string $model = Facturacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Facturaciones';
    protected static ?string $label = 'Facturaciones';
    protected static ?int $navigationSort = 4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListFacturacions::route('/'),
            'create' => Pages\CreateFacturacion::route('/create'),
            'edit' => Pages\EditFacturacion::route('/{record}/edit'),
        ];
    }
}
