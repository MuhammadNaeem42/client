<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationExternalOfficeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_external_office_transaction', function (Blueprint $table) {
            $table->id();


            $table->text('note')->nullable();
            $table->date('date')->nullable();

            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('external_office_transaction_id')->nullable();

            $table->foreign('external_office_transaction_id','eo_transaction_id')->references('id')->on('external_office_transactions')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('application_id')->references('id')->on('applications')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('created_by_id')->nullable(); //created_by_id
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('application_external_office_transaction');
    }
}
