<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //post_key, result_url, result_title, loc_id.
        Schema::create('task_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')
                ->references('id')->on('tasks')
                ->onDelete('cascade');
            $table->string('post_key');
            $table->string('result_url');
            $table->string('result_title');
            $table->bigInteger('loc_id');
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
        Schema::dropIfExists('task_results');
    }
}
