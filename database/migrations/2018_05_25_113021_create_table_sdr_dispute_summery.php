<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSdrDisputeSummery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdr_dispute_summery', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->unsignedInteger('disputeID');
            $table->smallInteger('disputeType')->comment('1:Exact Match, 2:Mismatch=1sec, 3:Mismatch=2sec, 4:Table One CDR Only, 5:Table Two CDR Only.');
            $table->string('A1', 255)->nullable();
            $table->string('A2', 255)->nullable();
            $table->string('A3', 255)->nullable();
            $table->string('B1', 255)->nullable();
            $table->string('B2', 255)->nullable();
            $table->string('B3', 255)->nullable();
            $table->timestamps();
            $table->foreign('disputeID')->references('id')->on('disputes')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sdr_dispute_summery');
    }
}
