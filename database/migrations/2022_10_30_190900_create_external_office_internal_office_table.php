<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalOfficeInternalOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_office_internal_office', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_office_id');
            $table->unsignedBigInteger('internal_office_id');
            $table->foreign('external_office_id')->references('id')->on('external_offices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('internal_office_id')->references('id')->on('internal_offices')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_office_internal_office');
    }
}
