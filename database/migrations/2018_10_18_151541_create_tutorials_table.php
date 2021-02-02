<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {   //utworzenie tabeli tutorials
            $table->increments('id');
            $table->integer('user_id');
            $table->string('banner')->default("default_banner.png");
            $table->string('bannerM')->default("default_bannerM.png");
            $table->string('video')->default("video.mp4");
            $table->integer('category_id');
            $table->string('title');
            $table->longtext('body')->nullable();;
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
        Schema::dropIfExists('tutorials'); //usuwanie tabeli tutorials
    }
}
