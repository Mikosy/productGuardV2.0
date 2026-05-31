<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Start a query
        $query = User::query();

        // Simple Search Logic: Search by name or email
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Fetch users with 10 per page
        $users = $query->latest()->paginate(10);

        return view('admin.index', compact('users'));
    }

    // VIEW: Show specific user details
    public function show(User $user)
    {
        return view('admin.show', compact('user'));
    }

    // EDIT: Show the form
    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    // UPDATE: Save changes
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'  => 'required|in:admin,consumer,depot_officer',
            'state' => 'nullable|string|max:100',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    // DELETE: Remove user
    public function destroy(User $user)
    {
        // Safety check: Don't let admin delete themselves
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User removed from registry.');
    }
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        dd($request->all());

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'in:admin,consumer,depot_officer'], // Added admin just in case
            'state' => ['nullable', 'string', 'max:100'],
        ]);

        // 1. Generate a random temporary password (e.g., "A7k9P2mQ")
        $temporaryPassword = Str::random(10);

        // 2. Add the hashed password to the data array
        $validated['password'] = Hash::make($temporaryPassword);

        // 3. Create the user
        $user = User::create($validated);

        // 4. Redirect with a success message showing the temp password
        return redirect()->route('admin.users')->with('success', 
            "User registered! Temp Password for {$user->name} is: {$temporaryPassword}"
        );
    }
}
