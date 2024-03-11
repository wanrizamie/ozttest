<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer-list', compact('customers'));
    }

    public function create()
    {
        return view('customer-create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => ['required', 'regex:/^01[0-9]{8,9}$/'],
            'email' => 'required|email|unique:customers,email', // Check for unique email
            'address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Add the image path to the validated data
        $validatedData['image'] = $imagePath;

        Customer::create($validatedData);

        return redirect()->route('customer-list')->with('success', 'Customer created successfully.');
    }


    public function edit(Customer $customer)
    {
        return view('customer-edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => ['required', 'regex:/^01[0-9]{8,9}$/'],
            'email' => 'required|email|unique:customers,email,'. $customer->id, // Check for unique email
            'address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update other customer data first
        $customer->update($validatedData);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($customer->image) {
                Storage::disk('public')->delete($customer->image);
            }
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $customer->image = $imagePath;
            $customer->save();
        }

        return redirect()->route('customer-list')->with('success', 'Customer updated successfully.');
    }


    public function destroy(Customer $customer)
    {
        // Ensure the customer exists before attempting to delete
        if (!$customer) {
            return redirect()->route('customer-list')->with('error', 'Customer not found.');
        }

        // Delete the customer
        $customer->delete();

        // Delete the associated image if it exists
        if ($customer->image) {
            // Delete the image from storage
            Storage::disk('public')->delete($customer->image);
        }

        return redirect()->route('customer-list')->with('success', 'Customer deleted successfully.');
    }
}
