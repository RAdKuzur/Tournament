<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefenceParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defence_participant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('act_defence_id')->constrained('act_defence');
            $table->integer('score');
            $table->unsignedBigInteger('student_id');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defence_participant');
    }
}
