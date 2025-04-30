<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 1000);
            $table->integer('type'); // 0 - круговой, 1 - олимпийская
            $table->date('begin_date');
            $table->date('finish_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
