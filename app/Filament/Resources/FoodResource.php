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

    protected static ?string $navigationIcon = 'heroicon-o-photo';
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
                    ->imagePreviewHeight('200'),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Grid::make(1)
                    ->schema([
                        // Gambar makanan
                        Tables\Columns\ImageColumn::make('image')
                            ->height(160)
                            ->width('100%')
                            ->extraImgAttributes([
                                'class' => 'rounded-md object-cover w-full h-40',
                            ]),

                        // Nama
                        Tables\Columns\TextColumn::make('name')
                            ->searchable()
                            ->size('md')
                            ->weight('bold')
                            ->alignCenter()
                            ->extraAttributes(['class' => 'mt-3']),

                        // Kategori
                        Tables\Columns\TextColumn::make('category.category_name')
                            ->label('Kategori')
                            ->alignCenter()
                            ->color('gray'),

                        // Harga
                        Tables\Columns\TextColumn::make('price')
                            ->label('Harga')
                            ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                            ->alignCenter()
                            ->weight('bold'),

                        // Deskripsi
                        Tables\Columns\TextColumn::make('desc')
                            ->label('Deskripsi')
                            ->alignCenter()
                            ->limit(40)
                            ->tooltip(fn($state) => $state),

                    ])
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 4,
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
