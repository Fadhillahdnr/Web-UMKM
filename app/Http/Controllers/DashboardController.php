<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Untuk user biasa: tampilkan order mereka
        if ($user->hasRole('user')) {
            $ordersCount = $user->orders()->count();
            $recentOrders = $user->orders()->with('orderItems.product')->latest()->take(5)->get();
            return view('user.dashboard', [
                'ordersCount' => $ordersCount,
                'recentOrders' => $recentOrders,
            ]);
        }

        // Untuk admin: tampilkan dashboard admin
        if ($user->hasRole('admin')) {
            $productsCount = Product::count();
            $ordersCount = Order::count();
            $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
            $recentOrders = Order::with('user', 'orderItems.product')->latest()->take(10)->get();

            return view('admin.dashboard', [
                'productsCount' => $productsCount,
                'ordersCount' => $ordersCount,
                'totalRevenue' => $totalRevenue,
                'recentOrders' => $recentOrders,
            ]);
        }

        // Untuk super admin: tampilkan dashboard super admin
        if ($user->hasRole('super_admin')) {
            $usersCount = User::count();
            $productsCount = Product::count();
            $ordersCount = Order::count();
            $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');

            return view('super_admin.dashboard', [
                'usersCount' => $usersCount,
                'productsCount' => $productsCount,
                'ordersCount' => $ordersCount,
                'totalRevenue' => $totalRevenue,
            ]);
        }

        abort(403);
    }
}
