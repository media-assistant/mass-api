<?php

namespace App\Library;

use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class Auth extends FacadesAuth
{
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
