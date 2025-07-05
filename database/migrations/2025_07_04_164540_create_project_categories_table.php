<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('intro')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedInteger('parent_id')->default(0);
            $table->unsignedInteger('level')->default(0);
            $table->string('slug')->nullable();
            $table->unsignedTinyInteger('show_home_page')->default(1);
            $table->unsignedInteger('order_number')->default(0);
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
        Schema::dropIfExists('project_categories');
    }
}
