<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToTablePostsDots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_posts_dots', function (Blueprint $table) {
            $table->string('product_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_posts_dots', function (Blueprint $table) {
            $table->dropColumn('product_price');
        });
    }
}
