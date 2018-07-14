<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('reference name');
            $table->unsignedInteger('agreement_id')->comment('Reference of agreement module.');
            $table->string('company')->comment('company name');
            $table->string('designation')->comment('reference person company designation');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();

            $table->foreign('agreement_id')->references('id')->on('agmt_lists')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
