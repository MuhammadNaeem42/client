<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationResellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_resells', function (Blueprint $table) {
            $table->id();
            $table->date('resell_date');
            $table->double('sponsor_refund');
            $table->boolean('paid_to_sponsor');
            $table->unsignedBigInteger('invoice_id');
            $table->enum('invoice_status', ['paid_full', 'paid_partial']);
            $table->double('invoice_amount');
            $table->double('invoice_due_amount');

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
        Schema::dropIfExists('application_resells');
    }
}
