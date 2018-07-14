<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgmtListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agmt_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->unsignedInteger('agmtTypeID')->comment('Agreement Type ID');
            $table->unsignedInteger('signatureID')->nullable()->comment('Signature ID');
            $table->string('value_a', 255)->nullable();
            $table->string('value_b', 255)->nullable();
            $table->string('value_c', 255)->nullable();
            $table->string('value_d', 255)->nullable();
            $table->smallInteger('status')->comment('1:Approved by Admin, 0:Not approved by admin yet.');
            $table->smallInteger('sendMail')->comment('1:Yes, 0:No.');
            $table->timestamps();
            $table->foreign('agmtTypeID')->references('id')->on('agmt_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('signatureID')->references('id')->on('signatures')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('agmt_lists');
    }
}
