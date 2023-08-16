<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_reservations', function (Blueprint $table) {
            $table->id();


            $table->string('passport_id')->nullable();
            $table->text('note')->nullable();

            $table->integer('reservation_days')->nullable();


            $table->date('reservation_date')->nullable();
            $table->date('pay_due_date')->nullable();

            $table->double('deal_amount', 8, 2)->default(0);
            $table->double('down_payment_amount', 8, 2)->default(0);

            $table->boolean('paid_immediately')->default(false);

            $table->boolean('status')->default(true);
            $table->date('cancellation_date')->nullable();

            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->unsignedBigInteger('invoice_sales_id')->nullable(); // TO DO:: With invoice sales

            $table->foreign('sponsor_id')->references('id')->on('sponsors')->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('application_reservations');
    }
}
