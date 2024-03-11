<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $users = User::all();
        return view('user-list', compact('users'));
    }

    // Show the form for creating a new user.
    public function create()
    {
        return view('user-create');
    }

    // Store a newly created user in storage.
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user-list')
            ->with('success', 'User created successfully.');
    }

    // Show the form for editing a user.
    public function edit(User $user)
    {
        return view('user-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the changes
        $user->save();

        // Redirect back with success message
        return redirect()->route('user-list')->with('success', 'User updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Check if the user to be deleted is the currently authenticated user
        if ($user->id === auth()->user()->id) {
            // Delete the user
            $user->delete();

            // Invalidate the user's session to force logout
            auth()->logout();

            // Redirect to the login page with a success message
            return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
        }

        // Delete the user
        $user->delete();

        // Redirect back to the user list with a success message
        return redirect()->route('user-list')->with('success', 'User deleted successfully.');
    }

}
