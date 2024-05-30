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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('portafolio_id');
            $table->foreign('portafolio_id')->references('id')->on('portafolios');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->decimal('amount', $precision = 10, $scale = 2);
            $table->integer('interest_rate');
            $table->integer('deadlines');
            $table->decimal('quota_value', $precision = 10, $scale = 2);
            $table->decimal('total_pay', $precision = 10, $scale = 2);
            $table->integer('payment_method')->default(1)->comment('1 - Diario, 2 - Semanal, 3 - Quincenal, 4 - Mensual');
            $table->integer('status')->default(1)->comment('1 - active, 2 - inactive, 3 - pendient');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('loans');
    }
};
