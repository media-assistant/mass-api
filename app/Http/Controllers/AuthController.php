<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Library\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function token(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        return response()->json(['token' => Auth::createToken($user)]);
    }

    public function user(): JsonResource
    {
        return UserResource::make(Auth::forceUser());
    }
}
