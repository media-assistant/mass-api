<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermissionTables extends Migration
{
    public function up(): void
    {
        $table_names  = config('permission.table_names');
        $column_names = config('permission.column_names');

        if (empty($table_names)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($table_names['permissions'], static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($table_names['roles'], static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($table_names['model_has_permissions'], static function (Blueprint $table) use ($table_names, $column_names): void {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($column_names['model_morph_key']);
            $table->index([$column_names['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($table_names['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $column_names['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($table_names['model_has_roles'], static function (Blueprint $table) use ($table_names, $column_names): void {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($column_names['model_morph_key']);
            $table->index([$column_names['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($table_names['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $column_names['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($table_names['role_has_permissions'], static function (Blueprint $table) use ($table_names): void {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($table_names['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($table_names['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store('default' != config('permission.cache.store') ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));

        $this->createRoles($this->createPermissions());
    }

    public function down(): void
    {
        $table_names = config('permission.table_names');

        if (empty($table_names)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($table_names['role_has_permissions']);
        Schema::drop($table_names['model_has_roles']);
        Schema::drop($table_names['model_has_permissions']);
        Schema::drop($table_names['roles']);
        Schema::drop($table_names['permissions']);
    }

    private function createPermissions(): array
    {
        $permissions = [
            'apis',
            'requests.admin',
            'requests.user',
        ];

        foreach ($permissions as $other_permission) {
            Permission::firstOrCreate(['name' => $other_permission]);
        }

        return $permissions;
    }

    private function createRoles(array $permissions): void
    {
        $roles = [
            'admin' => [...$permissions],
        ];

        foreach ($roles as $role => $role_permissions) {
            $role = Role::firstOrCreate(['name' => $role]);

            $permissions = Permission::whereIn('name', $role_permissions)->get();

            $role->permissions()->sync($permissions);
        }

        $admin = User::findOrFail(User::ADMIN);
        $admin->syncRoles(Role::where('name', 'admin')->firstOrFail());
    }
}
