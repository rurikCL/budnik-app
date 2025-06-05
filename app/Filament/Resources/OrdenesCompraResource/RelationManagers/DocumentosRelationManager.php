<?php

namespace App\Filament\Resources\OrdenesCompraResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentosRelationManager extends RelationManager
{
    protected static string $relationship = 'documentos';

    protected static ?string $modelLabel = 'Documento';
    protected static ?string $pluralLabel = 'Documentos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('NombreArchivo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('Path')
                ->preserveFilenames()
                ->downloadable()
                ->previewable(),
                Forms\Components\TextInput::make('Descripcion'),
                Forms\Components\Select::make('TipoArchivo')
                ->options([
                    'cotizacion' => 'Cotizacion',
                    'especificacion' => 'Especificacion',
                    'guia despacho' => 'Guia despacho',
                    'factura' => 'Factura',
                    'comprobante' => 'Comprobante',
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Documentos')
            ->columns([
                Tables\Columns\TextColumn::make('NombreArchivo'),
                Tables\Columns\TextColumn::make('Path'),
                Tables\Columns\TextColumn::make('TipoArchivo'),
                Tables\Columns\TextColumn::make('Estado'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
