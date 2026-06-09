<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'nullable|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'nullable|boolean',
            'status' => 'nullable|in:active,banned',
        ]);

        $validated['password'] = Hash::make($request->password);
        $validated['is_admin'] = $request->has('is_admin') ? 1 : 0;
        $validated['status'] = $request->input('status', 'active');

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo thành công!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'nullable|boolean',
            'status' => 'nullable|in:active,banned',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['is_admin'] = $request->has('is_admin') ? 1 : 0;
        $validated['status'] = $request->input('status', $user->status ?? 'active');

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được cập nhật!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa!');
    }

    /**
     * Ban a user
     */
    public function ban(User $user)
    {
        if ($user->isAdmin()) {
            return back()->withErrors('Không thể khóa tài khoản admin!');
        }

        $user->update(['status' => 'banned']);
        return back()->with('success', 'Tài khoản đã bị khóa!');
    }

    /**
     * Unban a user
     */
    public function unban(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', 'Tài khoản đã được mở khóa!');
    }
}
