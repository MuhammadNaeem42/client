<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationDeliversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_delivers', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->date('deliver_date');

            $table->unsignedBigInteger('invoice')->nullable();
            $table->enum('pay_status', ['paid_full', 'paid_partial']);
            $table->double('paid_amount');
            $table->double('discount_amount');
            $table->double('total');
            $table->double('due');
            $table->string('note')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('application_delivers');
    }
}
