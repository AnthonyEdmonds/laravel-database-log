<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel');
            $table->dateTime('logged_at');
            $table->string('level');
            $table->string('message');

            // Context
            $table->string('file')->nullable();
            $table->unsignedSmallInteger('code')->nullable();
            $table->unsignedSmallInteger('line')->nullable();
            $table->text('trace')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
