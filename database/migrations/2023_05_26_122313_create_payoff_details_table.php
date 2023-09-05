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
        Schema::create('payoff_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('service_provider_id');
            $table->string('bank_name')->nullable();
            $table->string('account_type')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bic/swift')->nullable();
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
        Schema::dropIfExists('payoff_details');
    }
};
