<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_notice', function (Blueprint $table) {
            $table->string('id');
            $table->string('post_id');
            $table->string('user_id');
            $table->text('content');
            $table->string('link')->nullable();
            $table->string('status')->default("Not seen");
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
        Schema::dropIfExists('tbl_notice');
    }
}
