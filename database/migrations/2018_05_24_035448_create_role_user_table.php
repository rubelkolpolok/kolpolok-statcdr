<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->comment('Role ID');
            $table->unsignedInteger('user_id')->comment('User ID');
            $table->smallInteger('userPlan')->nullable()->comment('Admin Type User\'s Plan ID: 1:Plan1, 2:Plan2, 3:Plan3');
            $table->unsignedInteger('parentID')->nullable()->comment('Parent ID');
            $table->smallInteger('userType')->nullable()->comment('User\'s Type: 1:Customer, 2:Vendor, 3:Bilateral, 4:Employee');
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parentID')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
