<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Widgets\OrderStats;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompletedOrdersResource\Pages;
use App\Filament\Resources\CompletedOrdersResource\RelationManagers;
use App\Filament\Resources\CompletedOrdersResource\Widgets\OrderStats as WidgetsOrderStats;

class CompletedOrdersResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $breadcrumb = 'Completed Orders';
    protected static ?string $navigationLabel = 'Completed Orders';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function getModelLabel(): string
    {
        return 'Completed Orders';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_id')->searchable()->alignCenter(),
                TextColumn::make('user.name')->label('Name')->alignCenter(),
                TextColumn::make('order_date')
                    ->label('Order Date')
                    ->date('d M Y')
                    ->alignCenter(),

                TextColumn::make('order_time')
                    ->label('Order Time')
                    ->date('H:i')
                    ->alignCenter(),
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
                Tables\Actions\Action::make('Order Details')
                    ->label('Order Details')
                    ->icon('heroicon-o-inbox-stack')
                    ->color('info')
                    ->modalHeading('Ordered Foods')
                    ->modalSubheading(fn($record) => 'Order ID: ' . $record->order_id)
                    ->modalContent(function ($record) {
                        $html = '<ul class="space-y-4">';

                        foreach ($record->orderDetail as $detail) {
                            $food = $detail->food;

                            $imageTag = $food
                                ? "<div class='flex-shrink-0'>
                    <img src='{$food->image_url}' 
                         alt='{$food->name}' 
                         style='width:120px; height:120px; object-fit:cover; border-radius:8px;' />
               </div>"
                                : '';

                            $html .= "
        <li class='flex items-center gap-4 p-3 rounded-xl bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition'>
            {$imageTag}
            <div class='flex-1'>
                <span class='font-semibold text-base block text-gray-800 dark:text-gray-100'>{$food->name}</span>
                <span class='text-sm text-gray-500 dark:text-gray-400'>Quantity: {$detail->quantity}</span><br>
<span class='text-sm text-gray-500 dark:text-gray-400'>Price: IDR " . number_format($food->price, 0, ',', '.') . "</span>
            </div>
        </li>
        ";
                        }

                        $html .= '</ul>';

                        return new \Illuminate\Support\HtmlString($html);
                    })


                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalFooterActionsAlignment('end')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_any_completed::orders');
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'delivered');
    }

    public static function getWidgets(): array
    {
        return [
            WidgetsOrderStats::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompletedOrders::route('/'),
            // 'create' => Pages\CreateCompletedOrders::route('/create'),
            // 'edit' => Pages\EditCompletedOrders::route('/{record}/edit'),
        ];
    }
}
