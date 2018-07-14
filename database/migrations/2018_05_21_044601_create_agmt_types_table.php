<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgmtTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agmt_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->string('typeName', 255);
            $table->smallInteger('adminApprove')->comment('1:Yes, 0:No');
            $table->integer('showOrder');
            $table->text('pdfDetails');
            $table->timestamps();
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
        Schema::dropIfExists('agmt_types');
    }
}
