<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('previous_id')->unique()->nullable();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['user_id']);

            $table->uuid('ad_id');
            $table->foreign('ad_id')->references('id')->on('ads')
                ->onDelete('cascade');
            $table->index(['ad_id']);

            $table->boolean('publish');//true - опубликовать,false -  отправить на доработку
            $table->index(['publish']);

            $table->string('reason',80);
            $table->timestamps();

        });
        Schema::table('moderations', function (Blueprint $table)
        {
            $table->foreign('previous_id')->references('id')->on('moderations')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moderations');
    }
}
