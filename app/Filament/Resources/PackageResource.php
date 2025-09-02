<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use Illuminate\Support\Str;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Package Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(1000),
                    ])->columns(1),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->minValue(0),
                        Forms\Components\TextInput::make('discount_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->nullable(),
                        Forms\Components\TextInput::make('duration_days')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->suffix('hari'),
                    ])->columns(3),

                Forms\Components\Section::make('Features & Limits')
                    ->schema([
                        Forms\Components\TextInput::make('max_guests')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->hint('0 = unlimited'),
                        Forms\Components\TextInput::make('max_photos')
                            ->numeric()
                            ->minValue(0)
                            ->default(10),
                        Forms\Components\TextInput::make('template_access')
                            ->numeric()
                            ->minValue(0)
                            ->default(3)
                            ->hint('Jumlah template yang bisa diakses'),
                    ])->columns(3),

                Forms\Components\Section::make('Features')
                    ->schema([
                        Forms\Components\Toggle::make('custom_domain')
                            ->default(false),
                        Forms\Components\Toggle::make('premium_support')
                            ->default(false),
                        Forms\Components\Toggle::make('background_music')
                            ->default(true),
                        Forms\Components\Toggle::make('photo_gallery')
                            ->default(true),
                        Forms\Components\Toggle::make('guest_book')
                            ->default(true),
                        Forms\Components\Toggle::make('countdown_timer')
                            ->default(true),
                        Forms\Components\Toggle::make('google_maps')
                            ->default(true),
                        Forms\Components\Toggle::make('qr_code')
                            ->default(true),
                    ])->columns(4),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Package')
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->suffix(' hari')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_featured')
                    ->label('Featured Packages'),
                Tables\Filters\Filter::make('is_active')
                    ->label('Active Packages'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
