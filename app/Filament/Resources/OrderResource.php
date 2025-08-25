<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $breadcrumb = 'Order';
    protected static ?string $navigationLabel = 'Order';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Order Management';

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
                TextColumn::make('transaction_id')->searchable()->alignCenter(),
                TextColumn::make('user.name')->label('Name')->alignCenter(),
                TextColumn::make('order_date')->label('Order Date')->alignCenter(),
                TextColumn::make('order_time')->label('Order Time')->alignCenter(),
                TextColumn::make('city')->alignCenter(),
                TextColumn::make('address')->alignCenter(),
                TextColumn::make('phone')->alignCenter(),
                TextColumn::make('status')->alignCenter()
                    ->formatStateUsing(fn($state) => ucfirst(strtolower($state)))
                    ->badge()
                    ->color(fn($state) => match (strtolower($state)) {
                        'confirmed' => 'warning',
                        'preparing' => 'danger',
                        'checking' => 'info',
                        'delivering' => 'primary',
                        'delivered' => 'success'
                    }),
                TextColumn::make('total')->alignCenter()->formatStateUsing(fn($state) => 'IDR ' . number_format($state, 0, ',', '.')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('MarkAsPreparing')
                    ->label('Mark as Preparing')
                    ->color('danger')
                    ->icon('heroicon-o-fire')
                    ->visible(fn($record) => auth()->user()->hasRole('Chef') && $record->status === 'confirmed')
                    ->disabled(fn($record) => $record->status === 'preparing')
                    ->action(fn($record) => $record->update(['status' => 'preparing'])),
                Tables\Actions\Action::make('MarkAsChecking')
                    ->label('Mark as Checking')
                    ->color('info')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->visible(fn($record) => auth()->user()->hasRole('Chef') && $record->status === 'preparing')
                    ->disabled(fn($record) => $record->status === 'checking')
                    ->action(fn($record) => $record->update(['status' => 'checking'])),
                Tables\Actions\Action::make('MarkAsDelivering')
                    ->label('Mark as Delivering')
                    ->color('primary')
                    ->icon('heroicon-o-truck')
                    ->visible(fn($record) => auth()->user()->hasRole('Driver') && $record->status === 'checking')
                    ->disabled(fn($record) => $record->status === 'delivering')
                    ->action(fn($record) => $record->update(['status' => 'delivering'])),
                Tables\Actions\Action::make('MarkAsDelivered')
                    ->label('Mark as Delivered')
                    ->color('success')
                    ->icon('heroicon-o-map-pin')
                    ->visible(fn($record) => auth()->user()->hasRole('Driver') && $record->status === 'delivering')
                    ->disabled(fn($record) => $record->status === 'delivered')
                    ->action(fn($record) => $record->update(['status' => 'delivered'])),
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('Chef')) {
                $query->whereIn('status', ['confirmed', 'preparing']);
            } elseif ($user->hasRole('Driver')) {
                $query->whereIn('status', ['checking', 'delivering']);
            } elseif ($user->hasRole('Manager')) {
                $query->where('status', 'delivered');
            }
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
