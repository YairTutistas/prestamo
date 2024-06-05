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
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
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
            $table->softDeletes(); // Columna deleted_at
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
