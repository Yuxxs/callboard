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

            $table->uuid('previous_id')->unique();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['user_id']);

            $table->uuid('ad_id');
            $table->foreign('ad_id')->references('id')->on('ads')
                ->onDelete('cascade');
            $table->index(['ad_id']);

            $table->string('decision',36);
            $table->index(['decision']);

            $table->string('reason',80);
            $table->timestamp('moderation_date');
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
