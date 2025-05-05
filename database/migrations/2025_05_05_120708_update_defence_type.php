<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefenceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('act_defence', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('defence', function (Blueprint $table) {
            $table->integer('type');
        });
        Schema::table('defence', function (Blueprint $table) {
            $table->date('date'); // Формат: YYYY-MM-DD
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defence', function (Blueprint $table) {
        $table->dropColumn('date');
        });
        Schema::table('defence', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('act_defence', function (Blueprint $table) {
            $table->integer('type');
        });
    }
}
