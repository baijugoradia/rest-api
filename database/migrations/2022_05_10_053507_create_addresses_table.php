<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('addresses_id');
            $table->string('address',100)->nullable();
            $table->string('address2',100)->nullable();
            $table->string('district',30)->nullable();
            $table->string('city',30)->nullable();
            $table->string('pincode',10)->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('employee_id')->on('employee')->onDelete('cascade');
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
        Schema::dropIfExists('addresses');
    }
}
