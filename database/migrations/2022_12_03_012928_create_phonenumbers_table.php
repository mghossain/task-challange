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
        Schema::create('phonenumbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customers_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->boolean('valid');
            $table->string('countryCode');
            $table->string('countryName');
            $table->string('operatorName');
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
        Schema::dropIfExists('phonenumbers_tables');
    }
};
