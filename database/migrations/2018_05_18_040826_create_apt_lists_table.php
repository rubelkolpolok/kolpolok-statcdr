<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAptListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apt_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->unsignedInteger('evtID')->comment('Event ID');
            $table->unsignedInteger('agentID')->comment('Agent ID');
            $table->unsignedInteger('slotID')->comment('Time Slot ID');
            $table->string('cusName', 255)->comment('Customer Name');
            $table->string('cusEmail', 255)->comment('Customer Email');
            $table->string('cusPhn', 255)->comment('Customer Phone/What\'s App ');
            $table->string('cusCom', 255)->comment('Customer Company');
            $table->string('cusSkype', 255)->comment('Customer Skype');
            $table->timestamps();
            $table->foreign('evtID')->references('id')->on('apt_events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('slotID')->references('id')->on('apt_time_slots')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['evtID', 'agentID', 'slotID']);
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
        Schema::dropIfExists('apt_lists');
    }
}
