<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Filament\Resources\UsersResource\RelationManagers;
use App\Models\User;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?string $navigationGroup = 'Administracion';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $label = 'Usuario';
    protected static ?string $pluralLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de Usuario')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required(),
                        Forms\Components\TextInput::make('email')->required(),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->autocomplete(false)
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state)),
/*                        Forms\Components\Select::make('idRole')
                            ->relationship('role', 'Rol')*/
//                            ->visible(fn() => Auth::user()->isRole('Administrador'))
                        Forms\Components\FileUpload::make('Foto')
                            ->disk('public')
                            ->directory('fotosUsuarios')
                            ->avatar()
                            ->imageEditor()
                            ->preserveFilenames()
                            ->moveFiles()
                            ->previewable()
                            ->deletable(true),
                    ])->columns(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\ImageColumn::make('Foto')
                            ->defaultImageUrl(url('/storage/fotosUsuarios/placeholderAvatar.png'))
                            ->circular()
                            ->grow(false),

                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\TextColumn::make('name')
                                ->label('Nombre')
                                ->searchable()
                                ->sortable(),

                            Tables\Columns\TextColumn::make('Rut')
                                ->label('Rut')
                                ->searchable()
                                ->sortable(),
                        ]),
                    ]),

                    Tables\Columns\TextColumn::make('email')
                        ->description('Email', position: 'above')
                        ->searchable()
                        ->sortable(),

                    Tables\Columns\TextColumn::make('EstadoNombre')
                        ->badge()
                        ->description('Estado', position: 'above'),

                    Tables\Columns\TextColumn::make('Estado')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'Activo' => 'info',
                            'Licencia' => 'warning',
                            'Baja' => 'danger',
                            default => 'gray',
                        }),

                    Tables\Columns\TextColumn::make('created_at')
                        ->date("d/m/Y")
                        ->description('Fecha Creacion', position: 'above')
                        ->label('Creado')
                        ->visibleFrom('md'),
                ])


            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button(),
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
            'index' => Pages\ListPersonas::route('/'),
            'create' => Pages\CreatePersonas::route('/create'),
            'edit' => Pages\EditPersonas::route('/{record}/edit'),
        ];
    }
}
