<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBooth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booth', function (Blueprint $table) {
            $table->increments('id_booth');
            $table->string('directory_logo');
            $table->string('logo_name');
            $table->string('nama_produk');
            $table->string('anggota_kelompok');
            $table->string('deskripsi_produk');
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
        Schema::drop('booth');
    }
}
