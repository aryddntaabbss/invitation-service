<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateResource\Pages;
use Illuminate\Support\Str;
use App\Models\Template;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Template Information')
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
                        Forms\Components\Select::make('category')
                            ->options(Template::getCategories())
                            ->required()
                            ->native(false),
                    ])->columns(1),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('preview_image')
                            ->image()
                            ->required()
                            ->directory('templates/previews')
                            ->maxSize(2048),
                    ]),

                Forms\Components\Section::make('Pricing & Status')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->default(0),
                        Forms\Components\Toggle::make('is_premium')
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])->columns(4),

                Forms\Components\Section::make('Design Properties')
                    ->schema([
                        Forms\Components\KeyValue::make('colors')
                            ->keyLabel('Color Name')
                            ->valueLabel('Hex Code')
                            ->addable(true)
                            ->editableKeys(true)
                            ->editableValues(true),
                        Forms\Components\KeyValue::make('fonts')
                            ->keyLabel('Font Name')
                            ->valueLabel('Font Family')
                            ->addable(true)
                            ->editableKeys(true)
                            ->editableValues(true),
                    ])->columns(1),

                Forms\Components\Section::make('Metadata')
                    ->schema([
                        Forms\Components\TextInput::make('version')
                            ->default('1.0.0'),
                        Forms\Components\TextInput::make('author')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('author_url')
                            ->url()
                            ->maxLength(255),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('preview_image')
                    ->label('Preview')
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_premium')
                    ->boolean()
                    ->label('Premium'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('download_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(Template::getCategories()),
                Tables\Filters\Filter::make('is_premium')
                    ->label('Premium Templates'),
                Tables\Filters\Filter::make('is_active')
                    ->label('Active Templates'),
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
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
