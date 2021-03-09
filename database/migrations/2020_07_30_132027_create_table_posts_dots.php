<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePostsDots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_posts_dots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->default(0);
            $table->string('serialized_coords')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_handle')->nullable();
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
        Schema::dropIfExists('table_posts_dots');
    }
}
