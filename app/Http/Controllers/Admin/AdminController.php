<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'completed')->sum('total_amount');
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();

        // Recent orders
        $recentOrders = Order::latest()->take(10)->get();

        // Sales this month
        $currentMonth = Carbon::now()->startOfMonth();
        $monthlySales = Order::where('payment_status', 'completed')
            ->whereDate('created_at', '>=', $currentMonth)
            ->sum('total_amount');

        // Inventory summary
        $inventorySummary = Inventory::whereDate('created_at', '>=', $currentMonth)
            ->groupBy('product_id')
            ->selectRaw('product_id, SUM(quantity_produced) as produced, SUM(quantity_sold) as sold')
            ->with('product')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 'lowStockProducts',
            'recentOrders', 'monthlySales', 'inventorySummary'
        ));
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
