<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin',
        ]);

        // Create a new user using the validated data
        $user = new User([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']), // Hash the password
            'role' => $validatedData['role'],
        ]);

        $user->save();

        // Redirect to the index page for users or a different view
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if(!$user)
            return redirect()->route('not.found');

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'username' => [
                'required',
                'string',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|min:6',
            'role' => 'required|in:user,admin',
        ]);

        // Retrieve the user to be updated
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Update the user's information using the validated data
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']); // Hash the new password
        }

        $user->role = $validatedData['role'];

        if($user->isDirty()){
            $user->save(); // Save the updated account
            return redirect()->back()->with('success', 'User account updated successfully');
        }

        $user->save();

        // Redirect back with message
        return redirect()->back()->with('info', 'No changes were made');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Account Deleted successfully');
    }

    public function profile(Request $request, string $id){
        $user = User::find($id);
        if (!$user || $user->id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Forbidden access');
        }
        return route('users.edit', [
            'user' => $user
        ]);
    }

    public function history(Request $request, string $id){
        $user = User::find($id);
        if(empty($user)){
            return redirect()->back()->with('error', 'User Not Found');
        }

        return view('admin.users.history', [
            'sales' => $user->sales,
            'saleItems' => $user->saleItems,
        ]);
    }
}
