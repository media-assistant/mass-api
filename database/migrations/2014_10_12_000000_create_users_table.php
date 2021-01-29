<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        $this->creatAdmin();
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }

    private function creatAdmin(): void
    {
        $user                    = new User();
        $user->id                = User::DEFAULT;
        $user->name              = 'admin';
        $user->email             = 'admin@gmail.com';
        $user->email_verified_at = now();
        $user->password          = bcrypt(config('admin_initial_password'));
        $user->save();
    }
}
