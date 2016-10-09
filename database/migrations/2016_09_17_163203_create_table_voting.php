<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVoting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forbiddenemail', function (Blueprint $table) {
            $table->increments('id_forbiddenemail');
            $table->string('forbidden_email', 60);
        });


        Schema::create('vote', function (Blueprint $table) {
            $table->increments('id_vote');
            $table->unsignedInteger('id_booth');
            $table->string('email');
            $table->string('vote_code');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::table('vote', function (Blueprint $table) {
            $table->foreign('id_booth')
                ->references('id_booth')->on('booth')
                ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forbiddenemail');
        Schema::drop('vote');
    }
}
