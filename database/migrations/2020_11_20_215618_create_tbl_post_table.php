<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_post', function (Blueprint $table) {
            $table->string('id');
            $table->string('author_id');
            $table->string('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('content');
            $table->string('status')->nullable();
            $table->boolean('is_post');
            $table->boolean('allow_comment')->default(true);
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_post');
    }
}
