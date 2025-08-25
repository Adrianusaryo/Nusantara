<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $order = (new Order())->sumOrderPrice();
    return $order;
});
