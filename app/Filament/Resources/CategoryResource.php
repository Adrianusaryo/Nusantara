<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $breadcrumb = 'Cuisine';
    protected static ?string $navigationLabel = 'Cuisine';
    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';
    protected static ?string $navigationGroup = 'Menu Management';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Cuisine';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('category_name')->required()->label('Category Name'),
                TextInput::make('description')->required()->label('Description Category Name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_name')->searchable()->alignCenter()->label('Cuisine'),
                TextColumn::make('description')->alignCenter()
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            // 'create' => Pages\CreateCategory::route('/create'),
            // 'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
