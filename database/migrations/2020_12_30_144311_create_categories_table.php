<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->index('parent_id');
            $table->tinyInteger('level')->unsigned()->default(0);
            $table->string('name',36);
            $table->string('slug',36)->unique();
            $table->string('description',200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('categories', function (Blueprint $table)
        {
            $table->foreign('parent_id')->references('id')->on('categories')
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
        Schema::dropIfExists('categories');
    }
}
