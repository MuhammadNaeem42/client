<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsInternalOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_offices', function (Blueprint $table) {

            $table->string('num_ministry_commerce')->nullable();
            $table->string('manpower')->nullable();

            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();

            $table->foreign('country_id')->on('countries')->references('id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('currency_id')->on('currencies')->references('id')->cascadeOnUpdate()->nullOnDelete();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
