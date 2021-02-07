<?php

use App\Library\Migration;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $this->createTimestamps($table);
        });

        $this->createAdmin();
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }

    private function createAdmin(): void
    {
        $user             = new User();
        $user->id         = User::ADMIN;
        $user->name       = 'admin';
        $user->email      = 'admin@gmail.com';
        $user->password   = bcrypt(config('mass.admin_initial_password'));
        $user->created_by = User::ADMIN;
        $user->updated_by = User::ADMIN;
        $user->save();
    }
}
