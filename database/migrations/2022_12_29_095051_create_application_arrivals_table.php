<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationArrivalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_arrivals', function (Blueprint $table) {
            $table->id();

            $table->string('flight_no');
            $table->string('flight_agent_name');
            $table->date('transaction_date');
            $table->date('arrival_date');
            $table->date('application_email_date');


            $table->string('note')->nullable();

            $table->boolean('status')->default(true);
            $table->date('cancellation_date')->nullable();

            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->nullOnDelete()->cascadeOnUpdate();


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
        Schema::dropIfExists('application_arrivals');
    }
}
