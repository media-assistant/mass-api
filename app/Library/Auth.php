<?php

namespace App\Library;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class Auth
{
    public static function createToken(User $user, string $device_name): string
    {
        try {
            DB::beginTransaction();

            $user->tokens()->delete();

            $token = $user->createToken($device_name)->plainTextToken;

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        return $token;
    }
}
