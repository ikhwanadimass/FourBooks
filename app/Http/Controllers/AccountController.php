<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only admin can access
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $accounts = User::where('id', '!=', auth()->id())->get();

        return view('pages.account.index', [
            'accounts' => $accounts,
            'title' => 'Akun',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admin can access
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:staff,user',
        ]);

        // Generate random password
        $password = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 12);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Only admin can access
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dihapus');
    }
}
