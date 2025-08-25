<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Food;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FoodResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FoodResource\RelationManagers;
use Filament\Forms\Components\Select;

class FoodResource extends Resource
{
    protected static ?string $model = Food::class;
    protected static ?string $breadcrumb = 'Food ';
    protected static ?string $navigationLabel = 'Food';
    protected static ?string $navigationGroup = 'Menu Management';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Food Name'),
                Select::make('category_id')->relationship('category', 'category_name')->required()->label('Food Category'),
                TextInput::make('price')->required()->label('Price'),
                TextInput::make('desc')->required()->label('Description'),
                FileUpload::make('image')
                    ->label('Food Image')
                    ->directory('items')
                    ->image()
                    ->preserveFilenames(false)
                    ->getUploadedFileNameForStorageUsing(function ($file): string {
                        $timestamp = Carbon::now()->timestamp;
                        $originalName = $file->getClientOriginalName();
                        return $timestamp . '-' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    })
                    ->required()
                    ->imagePreviewHeight('200'),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('category.category_name'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(function ($state) {
                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('desc'),
                ImageColumn::make('image')
                    ->width(60)
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
            'index' => Pages\ListFood::route('/'),
            // 'create' => Pages\CreateFood::route('/create'),
            // 'edit' => Pages\EditFood::route('/{record}/edit'),
        ];
    }
}
