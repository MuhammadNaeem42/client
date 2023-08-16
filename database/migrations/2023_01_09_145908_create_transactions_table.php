<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('payment_solutions');
            $table->unsignedBigInteger('external_office_id')->nullable();
            $table->foreign('external_office_id')->references('id')->on('external_offices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->double('send_dollar')->nullable();
            $table->date('deliver_date')->nullable();
            $table->string('from_bank_account')->nullable();
            $table->string('ref_payment')->nullable();
            $table->double('rate_on_dollar')->nullable();
            $table->double('total_local_currency')->nullable();
            $table->double('fess')->nullable();
            $table->double('total_in_kwd')->nullable();
            $table->string('references_files')->nullable();
            $table->double('balance_external_office');
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->nullOnDelete()->cascadeOnUpdate();
            $table->double('price_in_kwd')->nullable();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->foreign('application_id')->references('id')->on('applications')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('payment_type')->nullable();
            $table->string('recipient')->nullable();
            $table->double('amount')->nullable();
            $table->double('paid_payment')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('due')->nullable();
            $table->string('note')->nullable();
            $table->string('application_code')->nullable();
            $table->double('amount_commission')->nullable();
            $table->unsignedBigInteger('internal_office_id')->nullable();
            $table->foreign('internal_office_id')->references('id')->on('internal_offices')->nullOnDelete()->cascadeOnUpdate();
            $table->string('to')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
