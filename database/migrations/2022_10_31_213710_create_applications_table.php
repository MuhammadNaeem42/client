<?php

use App\StateMachines\StatusStateApplication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            ### Start personal info ###
            $table->string('code')->unique()->index();

            $table->string('name_en');
            $table->string('name_ar')->nullable();

            $table->text('address_en')->nullable();
            $table->text('address_ar')->nullable();

            $table->unsignedTinyInteger('age')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->unsignedTinyInteger('kids_no')->default(0);

            $table->string('photo')->nullable();
            $table->string('full_body_photo')->nullable();

            $table->unsignedDecimal('housemaid_price', 10, 2)->default(0);
            $table->unsignedDecimal('salary', 10, 2)->default(0);
            $table->unsignedDecimal('office_commission', 10, 2)->default(0); // get from external_office to save office_commission at this application

            $table->unsignedBigInteger('currency_id')->nullable(); // get from external_office to save currency this application
            $table->foreign('currency_id')->on('currencies')->references('id')->cascadeOnUpdate()->nullOnDelete();

            $table->unsignedBigInteger('external_office_id')->nullable();
            $table->foreign('external_office_id')->references('id')->on('external_offices')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('internal_office_id')->nullable();
            $table->foreign('internal_office_id')->references('id')->on('internal_offices')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->nullOnDelete()->cascadeOnUpdate();
            ### End personal info ###


            ### Start passport info ###
            $table->string('passport_no')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('place_birth')->nullable();

            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->nullOnDelete()->cascadeOnUpdate();
            ### End passport info ###


            ### Start skills info ###
            $table->string('english_skills')->nullable();
            $table->string('arabic_skills')->nullable();
            $table->string('experience')->nullable();
            $table->text('experience_details')->nullable();

            $table->unsignedBigInteger('job_id')->nullable();
            $table->foreign('job_id')->references('id')->on('jobs')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('religion_id')->nullable();
            $table->foreign('religion_id')->references('id')->on('religions')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('education_id')->nullable();
            $table->foreign('education_id')->references('id')->on('educations')->nullOnDelete()->cascadeOnUpdate();
            ### End skills info ###

            ### Start system info ###
            $table->string('status')->default(StatusStateApplication::APPLICATION);

            $table->unsignedBigInteger('created_by_id')->nullable(); //created_by
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('responsible_user_id')->nullable(); //created_by
            $table->foreign('responsible_user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->timestamps();
            ### End system info ###

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
