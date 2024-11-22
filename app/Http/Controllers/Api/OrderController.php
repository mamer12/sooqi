<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display all orders
    public function index()
    {
        $orders = Order::with('user', 'orderItems.product')->get();
        return response()->json($orders);
    }

    // Show a single order
    public function show(Order $order)
    {
        return response()->json($order->load('orderItems.product'));
    }

    // Store a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,completed,canceled',
        ]);

        $order = Order::create($validated);

        return response()->json($order, 201);
    }

    // Update an existing order
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'sometimes|required|string|in:pending,completed,canceled',
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    // Delete an order
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
