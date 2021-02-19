<?php

namespace App\Library;

use Illuminate\Database\Migrations\Migration as MigrationsMigration;
use Illuminate\Database\Schema\Blueprint;

class Migration extends MigrationsMigration
{
    public function createTimestamps(
        Blueprint $table,
        bool $soft_delete = false,
        bool $create_foreign_keys = true
    ): void {
        $table->unsignedInteger('created_by');
        $table->unsignedInteger('updated_by');
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        if ($create_foreign_keys) {
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        }

        if ($soft_delete) {
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();

            if ($create_foreign_keys) {
                $table->foreign('deleted_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            }
        }
    }
}
