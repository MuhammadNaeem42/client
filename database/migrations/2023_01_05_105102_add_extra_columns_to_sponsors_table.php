<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            //
            $table->renameColumn('civil_photo', 'front_civil_photo');
            $table->string('back_civil_photo')->nullable();
            $table->string('blood_type')->nullable();// A+,A-,B+,B-,O+,O-,AB+,AB-
            $table->date('expire_date_civil_card')->nullable();
            $table->date('birth_date')->nullable();


            ### start address info ###
            $table->string('unit_type')->nullable();// apartment, home
            $table->string('area')->nullable();
            $table->string('block')->nullable();
            $table->string('street')->nullable();
            $table->string('unit_no')->nullable();
            $table->string('floor')->nullable();
            $table->string('building_no')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('paci_unit_no')->nullable();
            $table->string('shipping_email')->nullable();
            $table->text('phones')->nullable()->default(null);
            ### end address info ###

            ### start work info ###
            $table->string('job_position')->nullable();
            $table->text('work_attachments')->nullable()->default(null);
            ### end work info ###


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            //
        });
    }
}
