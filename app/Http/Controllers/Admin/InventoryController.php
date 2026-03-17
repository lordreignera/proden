<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('inventory')->paginate(15);
        return view('admin.inventory', compact('products'));
    }

    public function addProduction($productId)
    {
        $product = Product::findOrFail($productId);
        return view('admin.add-production', compact('product'));
    }

    public function storeProduction(Request $request, $productId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($productId);

        // Create inventory record
        Inventory::create([
            'product_id' => $productId,
            'quantity_produced' => $validated['quantity'],
            'quantity_available' => $validated['quantity'],
            'transaction_type' => 'production',
            'notes' => $validated['notes'] ?? null,
            'transaction_date' => now()->toDateString(),
        ]);

        // Update product stock
        $product->increment('stock', $validated['quantity']);

        return redirect()->route('admin.inventory')->with('success', 'Production recorded!');
    }

    public function adjustment($productId)
    {
        $product = Product::findOrFail($productId);
        return view('admin.adjustment', compact('product'));
    }

    public function storeAdjustment(Request $request, $productId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($productId);
        $newStock = $product->stock + $validated['quantity'];

        // Don't allow negative stock
        if ($newStock < 0) {
            return redirect()->back()->with('error', 'Insufficient stock!');
        }

        // Create inventory record
        Inventory::create([
            'product_id' => $productId,
            'quantity_available' => abs($validated['quantity']),
            'transaction_type' => 'adjustment',
            'notes' => $validated['reason'] . ': ' . ($validated['notes'] ?? ''),
            'transaction_date' => now()->toDateString(),
        ]);

        // Update product stock
        $product->update(['stock' => $newStock]);

        return redirect()->route('admin.inventory')->with('success', 'Stock adjusted!');
    }

    public function report()
    {
        $report = Inventory::with('product')
            ->whereDate('created_at', '>=', now()->subMonth())
            ->get()
            ->groupBy('product_id');

        return view('admin.inventory-report', compact('report'));
    }
}
