<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlansTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_plans_terms', function (Blueprint $table) {
            $table->id();

            $table->integer('plan_id')->unsigned()->nullable();
            $table->longText('serialize_terms')->nullable();

            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_plans_terms');
    }
}
