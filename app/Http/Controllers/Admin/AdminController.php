<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function dashboard()
    {
        $currentMonth = Carbon::now()->startOfMonth();

        // Cache dashboard summary briefly to reduce repeated DB load on refresh.
        $summary = Cache::remember('admin.dashboard.summary', 60, function () use ($currentMonth) {
            return [
                'totalOrders' => Order::count(),
                'totalRevenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
                'totalProducts' => Product::count(),
                'lowStockProducts' => Product::where('stock', '<', 10)->count(),
                'monthlySales' => Order::where('payment_status', 'completed')
                    ->where('created_at', '>=', $currentMonth)
                    ->sum('total_amount'),
                'monthlyOrders' => Order::where('created_at', '>=', $currentMonth)->count(),
            ];
        });

        // Keep this query fresh and lightweight for most recent activity.
        $recentOrders = Order::select([
            'id',
            'order_number',
            'customer_name',
            'total_amount',
            'payment_status',
            'order_status',
            'created_at',
        ])->latest()->limit(10)->get();

        return view('admin.dashboard', array_merge($summary, [
            'recentOrders' => $recentOrders,
            'currentMonth' => $currentMonth,
        ]));
    }

    public function orders()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function orderDetail($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('admin.order-detail', compact('order'));
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($orderId);
        $order->update($validated);

        return redirect()->back()->with('success', 'Order status updated!');
    }
}
