<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgmtTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agmt_type_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->unsignedInteger('agmtTypeID')->comment('Agreement Type ID');
            $table->string('columnName', 255);
            $table->smallInteger('columnType')->comment('1:Text, 2:Date, 3:Email, 4:Number');
            $table->smallInteger('mustFill')->default(0)->comment('1:Yes, 0:No');
            $table->timestamps();
            $table->foreign('agmtTypeID')->references('id')->on('agmt_types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('agmt_type_details');
    }
}
