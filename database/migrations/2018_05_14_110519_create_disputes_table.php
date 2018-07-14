<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->increments('ID')->comment('Row ID');
            $table->unsignedInteger('userID')->comment('This the a Customer ID a.k.a. User ID');
            $table->smallInteger('dType')->comment('Dispute Type, 1:Customer, 2:Supplier');
            $table->string('dName')->comment('Dispute Name');
            $table->string('prtName', 255)->comment('Partner Name');
            $table->date('fromDate');
            $table->date('toDate');
            $table->string('dAmount', 255)->nullable()->comment('Dispute Amount (Estimate)');
            $table->date('dueDate')->nullable()->comment('Due Date');
            $table->smallInteger('colStatus')->default(0)->comment('Column Status, 1:Ready for Upload, 0:Not Ready for Upload');
            $table->smallInteger('uploadStatus')->default(0)->comment('1:Done, 0:In-Queue, -1:Currently Uploading');

            $table->string('aTableName', 255)->nullable();
            $table->string('bTableName', 255)->nullable();

            $table->integer('aDateColNo');
            $table->string('aDateZone', 255);
            $table->integer('aCallerColNo');
            $table->integer('aCalledColNo');
            $table->string('aCalledPrefix', 255)->nullable();
            $table->integer('aDurationColNo');
            $table->smallInteger('aDurationType')->comment('1:Second, 2:Minute');
            $table->integer('aRateColNo')->nullable();
            $table->integer('aCostColNo')->nullable();

            $table->integer('bDateColNo');
            $table->string('bDateZone', 255);
            $table->integer('bCallerColNo');
            $table->integer('bCalledColNo');
            $table->string('bCalledPrefix', 255)->nullable();
            $table->integer('bDurationColNo');
            $table->smallInteger('bDurationType')->comment('1:Second, 2:Minute');
            $table->integer('bRateColNo')->nullable();
            $table->integer('bCostColNo')->nullable();

            $table->string('aFile', 255)->nullable();
            $table->string('bFile', 255)->nullable();

            $table->string('aFileName', 255)->nullable()->comment('File A Real Name, which is uploaded.');
            $table->string('bFileName', 255)->nullable()->comment('File B Real Name, which is uploaded.');

            $table->unsignedInteger('aTotalCall')->nullable();
            $table->unsignedInteger('bTotalCall')->nullable();
            $table->unsignedInteger('aTotalSec')->nullable();
            $table->unsignedInteger('bTotalSec')->nullable();

            $table->string('aTotalCost', 255)->nullable();
            $table->string('bTotalCost', 255)->nullable();
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
        Schema::dropIfExists('disputes');
    }
}
