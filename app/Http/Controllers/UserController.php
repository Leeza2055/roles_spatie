<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = User::with('roles:id,name')->get();

        return Inertia::render('users/Index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $userParams = $request->validated();

        $user = User::create([
            'name' => $userParams['name'],
            'email' => $userParams['email'],
            'password' => Hash::make('password'),
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ]);

        $user->assignRole($userParams['roles']);
        Inertia::flash('toast', ['type' => 'success', 'message' => __('User: :user created successfully.', ['user' => $user->name])]);

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($this->permissionDenied($user)) {
            $this->permissionAccessMessage();

            return redirect()->route('dashboard');
        }

        return Inertia::render('users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        if ($this->permissionDenied($user)) {
            $this->permissionAccessMessage();

            return redirect()->route('dashboard');
        }

        $userParams = $request->validated();

        $user->update([
            'name' => $userParams['name'],
            'email' => $userParams['email'],
        ]);
        $user->removeRole($user->role_name);
        $user->assignRole($userParams['roles']);
        Inertia::flash('toast', ['type' => 'success', 'message' => __('User: :user updated successfully.', ['user' => $user->name])]);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::user()->id == $user->id) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => __('You cannot delete logged in user.'),
            ]);

            return redirect()->route('dashboard');
        }

        if ($this->permissionDenied($user)) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => __('You cannot delete super admin role'),
            ]);

            return redirect()->route('dashboard');
        }

        $user->delete();
        Inertia::flash('toast', ['type' => 'success', 'message' => __('User: :user deleted successfully.', ['user' => $user->name])]);

        return redirect()->route('users.index');
    }

    private function permissionDenied(User $user): bool
    {
        if (Auth::user()->role_name === 'super_admin' || (Auth::user()->role_name === 'admin' && $user->role_name != 'super_admin')) {
            return false;
        }

        return true;
    }

    private function permissionAccessMessage()
    {
        Inertia::flash('toast', [
            'type' => 'error',
            'message' => __('You do not have permission to access the page.'),
        ]);
    }
}
