<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_offices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->text('address_en')->nullable();
            $table->text('address_ar')->nullable();
            $table->string('phone')->nullable();
            $table->double('commission', 8, 2)->default(0.0);

            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();

            $table->foreign('country_id')->on('countries')->references('id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('currency_id')->on('currencies')->references('id')->cascadeOnUpdate()->nullOnDelete();

//            TODO implement accounting  Deferred Journal ,Recognized Journal,Suspense Account,Main Account (foreign key)

            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('external_offices');
    }
}
