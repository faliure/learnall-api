<?php

namespace App\Http\Controllers\Auth;

use App\Extensions\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $user = User::firstWhere('email', $request->email);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'user'  => $user->resource(),
            'token' => $user->createToken($request->device)->plainTextToken,
        ]);
    }

    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user()->resource(),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $current = $request->user()->currentAccessToken();

        $current->delete();

        return response()->json([
            'token' => $request->user()->createToken($current->name)->plainTextToken,
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
