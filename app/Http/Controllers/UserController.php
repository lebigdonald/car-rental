<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(20);

        if (Auth::guard('admin')->check()) {
            return view('admin.users')->with(compact('users'));
        } else {
            return redirect()->back();
        }
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
        } else {
            $user = Auth::user();
        }

        if (Auth::guard('admin')->check()) {
            return view('admin.user-details')->with(compact('user'));
        } else {
            return view('profile', compact('user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
        } else {
            $user = Auth::user();
        }

        if (Auth::guard('admin')->check()) {
            return view('admin.user-edit')->with(compact('user'));
        } else {
            // For regular users, we might use the same profile view but with a form
            return view('profile', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
        } else {
            $user = Auth::user();
        }

        $validatedData = $request->validated();

        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.user.index')->with('success', 'Utilisateur mis à jour avec succès.');
        } else {
            return redirect()->route('user.show')->with('success', 'Profil mis à jour avec succès.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::guard('admin')->check()) {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.user.index')->with('success', 'Utilisateur supprimé avec succès.');
        }
        return redirect()->back();
    }
}
