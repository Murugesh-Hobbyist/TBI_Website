<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', [
            'orders' => Order::query()->latest()->paginate(30),
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', ['order' => $order]);
    }
}

