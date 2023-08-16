<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankInfoToExternalOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_offices', function (Blueprint $table) {
            //
            $table->string('bank_info_name')->nullable();
            $table->string('bank_info_company_name')->nullable();
            $table->string('bank_info_beneficiary_name')->nullable();

            $table->string('bank_info_swift_code')->nullable();
            $table->string('bank_info_iban')->nullable();
            $table->string('bank_info_account_number')->nullable();
            $table->string('bank_info_phone')->nullable();

            $table->unsignedBigInteger('bank_info_country_id')->nullable();
            $table->unsignedBigInteger('bank_info_currency_id')->nullable();

            $table->foreign('bank_info_country_id')->on('countries')->references('id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('bank_info_currency_id')->on('currencies')->references('id')->cascadeOnUpdate()->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_offices', function (Blueprint $table) {
            $table->dropColumn('bank_info_name');
            $table->dropColumn('bank_info_company_name');
            $table->dropColumn('bank_info_beneficiary_name');
            $table->dropColumn('bank_info_swift_code');
            $table->dropColumn('bank_info_iban');
            $table->dropColumn('bank_info_account_number');
            $table->dropColumn('bank_info_phone');
            $table->dropColumn('bank_info_country_id');
            $table->dropColumn('bank_info_currency_id');
        });
    }
}
