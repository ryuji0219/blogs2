<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if(!Schema::hashtable('blogs2')){
            // Schema::create('blogs2', function (Blueprint $table) {
            //     $table->bigIncrements(id);
            //     $table->string('title',100)
            //  });
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->string('title',50);
                $table->text('content');
                $table->integer('user_id');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
            });
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
