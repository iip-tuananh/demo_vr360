<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoundersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('founders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('description')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_website')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_tiktok')->nullable();
            $table->string('email')->nullable();
            $table->string('zalo')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);
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
        Schema::dropIfExists('founders');
    }
}
