<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('profile')->nullable()->default('default.png');
            $table->string('phone_number')->nullable();
            $table->string('driving_license')->nullable();
            $table->string('ein_number')->nullable();
            $table->string('police_check')->nullable();
            $table->string('password')->nullable();
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->enum('type', ['admin', 'user','service_provider'])->default('user');
            $table->string('role_id')->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_token_expires_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
