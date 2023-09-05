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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('customer_id')->nullable();
            $table->tinyInteger('service_provider_id')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('service_plan_id')->nullable();
            $table->longText('service_plan_description')->nullable();
            $table->enum('status', ['pending','booked','arrived','dispute','completed'])->default('pending');

            /* Address */
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();

            $table->string('unit')->nullable();
            $table->string('building')->nullable();
            $table->string('suburb')->nullable();
            $table->string('street_address')->nullable();
            $table->string('street_address_2')->nullable();
            $table->string('state')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('urbanization')->nullable();

            /* Task Time and Date */
            $table->time("task_time")->nullable();
            $table->date("task_date")->nullable();


            /* Review */
            $table->longText('review')->nullable();
            $table->integer('stars')->nullable();

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
        Schema::dropIfExists('tasks');
    }
};
