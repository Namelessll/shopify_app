<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToTableInstagramPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_instagram_posts', function (Blueprint $table) {
            $table->bigInteger('id_post')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_instagram_posts', function (Blueprint $table) {
            $table->dropColumn('id_post');
        });
    }
}
