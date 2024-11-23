<?php

namespace App\Http\Controllers\Api;

use App\Models\User; // Assuming customers are stored in the default 'users' table
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Display a list of customers
    public function index()
    {
        $customers = User::where('role', 'customer')->get(); // Assuming a 'role' column
        return response()->json($customers);
    }

    // Show a single customer
    public function show(User $user)
    {
        return response()->json($user);
    }

    // Create a new customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']); // Hash password
        $validated['role'] = 'customer'; // Assign 'customer' role

        $customer = User::create($validated);

        return response()->json($customer, 201);
    }

    // Update an existing customer
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']); // Hash password
        }

        $user->update($validated);

        return response()->json($user);
    }

    // Delete a customer
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
