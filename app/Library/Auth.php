<?php

namespace App\Library;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class Auth extends FacadesAuth
{
    public static function forceUser(): User
    {
        $user = parent::user();

        if (null === $user) {
            throw new AuthenticationException();
        }

        return $user;
    }

    public static function createToken(User $user): string
    {
        try {
            DB::beginTransaction();

            $user->tokens()->delete();

            $token = $user->createToken('main')->plainTextToken;

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        return $token;
    }
}
