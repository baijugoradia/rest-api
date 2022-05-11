<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('firstname', 20)->nullable();
            $table->string('lastname', 20)->nullable();
            $table->string('email', 340)->nullable()->unique();
            $table->date('doj')->nullable()->comment('Date of Joining');
            $table->enum('gender', ['m', 'f', 'o'])->nullable();
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
        Schema::dropIfExists('employee');
    }
}
