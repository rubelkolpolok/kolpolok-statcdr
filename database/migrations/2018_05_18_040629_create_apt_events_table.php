<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAptEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apt_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->string('evtName')->unique()->comment('Event Name');
            $table->text('evtAddr')->comment('Event Address');
            $table->date('evtStart')->comment('Event Starting Date');
            $table->date('evtEnd')->comment('Event Ending Date');
            $table->date('evtShowWeb')->comment('Event Start Showing on Website DATE.');
            $table->timestamps();
            $table->unique(['evtName', 'evtStart']);
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
        Schema::dropIfExists('apt_events');
    }
}
