<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar')->nullable();

            $table->text('address_en')->nullable();
            $table->text('address_ar')->nullable();

            $table->string('civil_id')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();

            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('language')->nullable();
            $table->string('gender')->nullable();

            $table->string('photo')->nullable();
            $table->string('civil_photo')->nullable();

            $table->text('device_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();


            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('job_id')->nullable();
            $table->foreign('job_id')->references('id')->on('jobs')->nullOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('created_by_id')->nullable(); //created_by_id
            $table->foreign('created_by_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();


            $table->boolean('is_block')->default(false);
            $table->boolean('is_active')->default(false);

            $table->rememberToken();
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
        Schema::dropIfExists('sponsors');
    }
}
