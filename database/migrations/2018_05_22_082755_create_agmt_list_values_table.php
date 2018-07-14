<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgmtListValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agmt_list_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->unsignedInteger('agmtListID')->comment('Agreement List ID');
            $table->unsignedInteger('agmtTypeColumnID')->comment('Agreement Type Column ID');
            $table->string('columnValue', 255)->nullable();
            $table->timestamps();
            $table->foreign('agmtListID')->references('id')->on('agmt_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('agmtTypeColumnID')->references('id')->on('agmt_type_details')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('userID')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agmt_list_values');
    }
}
