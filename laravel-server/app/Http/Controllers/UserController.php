<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return $user->is_admin === true || $user->is_admin === 1;
    }

    public function index(Request $request)
    {
        if (!$this->checkAdmin()) return redirect('/login');

        $users = User::latest()->get();
        $editingUser = null;

        if ($request->has('edit')) {
            $editingUser = User::find($request->edit);
        }

        return view('users.index', compact('users', 'editingUser'));
    }

    public function store(Request $request)
    {
        if (!$this->checkAdmin()) return redirect('/login');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
            'role' => 'required|in:admin,participant',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->role === 'admin',
        ]);

        return redirect('/admin/users')->with('success', 'User created successfully!');
    }

    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin()) return redirect('/login');

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => ['nullable', Password::defaults()],
            'role' => 'required|in:admin,participant',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->role === 'admin',
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/admin/users')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        if (!$this->checkAdmin()) return redirect('/login');

        $user = User::findOrFail($id);

        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        // Delete results first
        QuizResult::where('user_id', $user->id)->delete();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function toggleDisqualification($id)
    {
        if (!$this->checkAdmin()) return redirect('/login');

        $user = User::findOrFail($id);
        $user->is_disqualified = !$user->is_disqualified;
        $user->save();

        $status = $user->is_disqualified ? 'banned' : 'active';
        return redirect()->back()->with('success', "User status updated: Account is now $status.");
    }
}
