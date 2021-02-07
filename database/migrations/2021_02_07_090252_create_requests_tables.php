<?php

use App\Library\Migration;
use App\Models\Request\RequestStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTables extends Migration
{
    public function up(): void
    {
        Schema::create('request_statuses', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name');
            $table->string('color');
            $table->string('icon');
        });

        $this->createStatuses();

        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('type');
            $table->unsignedInteger('item_id');
            $table->string('text');
            $table->string('image_url');
            $table->unsignedSmallInteger('request_status_id');

            $this->createTimestamps($table);

            $table->foreign('request_status_id')
                ->references('id')
                ->on('request_statuses')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_statuses');
        Schema::dropIfExists('requests');
    }

    private function createStatuses(): void
    {
        $statuses = [
            [
                'id'    => RequestStatus::REQUEST,
                'name'  => 'Request',
                'color' => 'grey',
                'icon'  => 'mdi-timer-sand',
            ],
            [
                'id'    => RequestStatus::APPROVED,
                'name'  => 'Approved',
                'color' => 'primary',
                'icon'  => 'mdi-check',
            ],
            [
                'id'    => RequestStatus::DOWNLOADING,
                'name'  => 'Downloading',
                'color' => 'primary',
                'icon'  => 'mdi-download',
            ],
            [
                'id'    => RequestStatus::DONE,
                'name'  => 'Done',
                'color' => 'success',
                'icon'  => 'mdi-cloud-check',
            ],
            [
                'id'    => RequestStatus::DENIED,
                'name'  => 'Denied',
                'color' => 'error',
                'icon'  => 'mdi-close',
            ],
            [
                'id'    => RequestStatus::ERROR,
                'name'  => 'Error',
                'color' => 'error',
                'icon'  => 'mdi-alert-circle',
            ],
        ];

        RequestStatus::insert($statuses);
    }
}
