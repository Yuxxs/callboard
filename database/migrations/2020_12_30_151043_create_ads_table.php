<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->index(['user_id']);

            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade');
            $table->index(['category_id']);

            $table->uuid('city_id');
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade');
            $table->index(['city_id']);

            $table->uuid('status_id');
            $table->foreign('status_id')->references('id')->on('ad_statuses');
            $table->index(['status_id']);

            $table->string('name',24);
            $table->string('description',200);

            $table->integer('cost')->unsigned();
            #$table->index(['cost']);

            $table->bigInteger('views_count')->unsigned();
            #$table->index(['views_count']);

            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
