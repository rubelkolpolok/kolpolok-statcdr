<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAptTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apt_time_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->unsignedInteger('evtID')->comment('Event ID');
            $table->unsignedInteger('agentID')->comment('Agent ID');
            $table->dateTime('time_slot');
            $table->integer('slot_duration');
            $table->timestamps();
            $table->foreign('evtID')->references('id')->on('apt_events')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['evtID', 'agentID', 'time_slot']);
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
        Schema::dropIfExists('apt_time_slots');
    }
}
