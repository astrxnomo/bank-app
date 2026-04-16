<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccountController extends Controller
{
    private const CACHE_TTL_SECONDS = 300;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Cache::remember('accounts:index', self::CACHE_TTL_SECONDS, fn () => Account::with('user')->get());
        return response()->json($accounts, 200);
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'type' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric'],
            'number' => ['required', 'string', 'max:255'],
        ]);

        $account = Account::create($validated);
        $this->clearAccountsCache($account->id);

        return response()->json($account, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        $cachedAccount = Cache::remember(
            "accounts:show:{$account->id}",
            self::CACHE_TTL_SECONDS,
            fn () => Account::with('user')->findOrFail($account->id)
        );

        return response()->json($cachedAccount, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
            'type' => ['sometimes', 'required', 'string', 'max:255'],
            'value' => ['sometimes', 'required', 'numeric'],
            'number' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $account->update($validated);
        $this->clearAccountsCache($account->id);

        return response()->json($account, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $id = $account->id;
        $account->delete();
        $this->clearAccountsCache($id);

        return response()->json(null, 204);
    }

    private function clearAccountsCache(?int $id = null): void
    {
        Cache::forget('accounts:index');

        if ($id !== null) {
            Cache::forget("accounts:show:{$id}");
        }
    }
}
