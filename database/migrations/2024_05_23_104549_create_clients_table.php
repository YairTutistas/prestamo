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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
    
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('type_document');
            $table->string('document');
            $table->string('phone');
            $table->string('email');
            $table->string('addresses');
            $table->string('department')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->integer('status')->default(1)->comment('1 - active, 2 - inactive');
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
        Schema::dropIfExists('clients');
    }
};
