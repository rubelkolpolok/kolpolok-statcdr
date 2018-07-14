<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPlaceholderInAgmtTypeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agmt_type_details', function (Blueprint $table) {
            $table->string('placeHolder', 255)->nullable()->comment('Column value will be affect in pdf Details with this place holder string.');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agmt_type_details', function (Blueprint $table) {
            $table->dropColumn('placeHolder');
        });
    }
}
