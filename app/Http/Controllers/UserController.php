<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::where('role', 'admin')->get();
        return view('users.admin.index', compact('users'));
    }

    public function staffIndex()
    {
        //
        $users = User::where('role', 'staff')->get();
        return view('users.staff.index', compact('users'));
    }

    public function staffsIndex()
    {
        //
        $users = User::all();
        return view('users.staff.index_staff', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff',
        ]);

        $password = substr($request->email, 0, 4) . (User::count() + 1);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($password),
        ]);

        return back()->with('success', 'User created successfully. Default password: ' . $password);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reset(string $id)
    {
        //
        $user = User::findOrFail($id);

        $defaultPassword = substr($user->email, 0, 4) . ($user->id);
        $user->password = bcrypt($defaultPassword);
        $user->save();

        return back()->with('success', 'Password reset successfully. New password: ' . $defaultPassword);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->new_password) {
            $user->password = bcrypt($request->new_password);
        }
        $user->save();

        return back()->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function login(Request $request) 
    {
        $login = $request->only('email', 'password');

        if (Auth::attempt($login)) {
            return redirect()->route('dashboard')->with('success', 'Berhasil Login');
        } else {
            return redirect()->back()->with('failed', 'Gagal Login');
        }
    }

    public function logout() 
    {
        Auth::logout();
        return redirect()->route('layout')->with('success', 'Berhasil Logout');
    }
}
