<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Models\Project;
use App\Models\Video;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'projects' => Project::count(),
                'videos' => Video::count(),
                'products' => Product::count(),
                'leads' => Lead::count(),
                'orders' => Order::count(),
            ],
            'latestLeads' => Lead::query()->latest()->limit(10)->get(),
            'latestOrders' => Order::query()->latest()->limit(10)->get(),
        ]);
    }
}

