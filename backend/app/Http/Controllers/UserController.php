<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    private const CACHE_TTL_SECONDS = 300;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Cache::remember('users:index', self::CACHE_TTL_SECONDS, fn () => User::all());
        return response()->json($users, 200);
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create($validated);
        $this->clearUsersCache($user->id);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $cachedUser = Cache::remember(
            "users:show:{$user->id}",
            self::CACHE_TTL_SECONDS,
            fn () => User::findOrFail($user->id)
        );

        return response()->json($cachedUser, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'required', 'string', 'min:8'],
        ]);

        $user->update($validated);
        $this->clearUsersCache($user->id);

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $id = $user->id;
        $user->delete();
        $this->clearUsersCache($id);

        return response()->json(null, 204);
    }

    private function clearUsersCache(?int $id = null): void
    {
        Cache::forget('users:index');

        if ($id !== null) {
            Cache::forget("users:show:{$id}");
        }
    }
}