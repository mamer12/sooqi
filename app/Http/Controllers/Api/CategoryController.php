<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Display all order items
    public function index()
    {
        $orderItems = OrderItem::with('product', 'order')->get();
        return response()->json($orderItems);
    }

    // Show a single order item
    public function show(OrderItem $orderItem)
    {
        return response()->json($orderItem->load('product', 'order'));
    }

    // Store a new order item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::create($validated);

        return response()->json($orderItem, 201);
    }

    // Update an existing order item
    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $orderItem->update($validated);

        return response()->json($orderItem);
    }

    // Delete an order item
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json(null, 204);
    }
}
