<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationVisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_visas', function (Blueprint $table) {
            $table->id();

            $table->date('transaction_date')->nullable();

            $table->string('sponsor_name_en')->nullable();
            $table->string('sponsor_name_ar')->nullable();

            $table->string('passport_id')->nullable();

            $table->integer('visa_issue_days')->nullable();
            $table->integer('visa_received_days')->nullable();

            $table->string('visa_no')->nullable();
            $table->string('visa_file_no')->nullable();
            $table->string('photo')->nullable();

            $table->date('visa_issue_date')->nullable();
            $table->date('visa_expiry_date')->nullable();
            $table->date('visa_received_date')->nullable();
            $table->date('visa_send_date')->nullable();

            $table->string('housemaid_unified_no')->nullable();
            $table->string('sponsor_unified_no')->nullable();

            $table->string('sponsor_address_en')->nullable();
            $table->string('sponsor_address_ar')->nullable();
            $table->string('place_of_issue')->nullable();


            $table->text('note')->nullable();

            $table->string('visa_status')->nullable();

            $table->boolean('status')->default(true);
            $table->date('cancellation_date')->nullable();

            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->nullOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('application_visas');
    }
}
