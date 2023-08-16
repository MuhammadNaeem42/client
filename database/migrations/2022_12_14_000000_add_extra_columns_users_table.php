<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->unique();
            $table->enum('type', ['internal_office', 'external_office', 'user'])->default('user');
            $table->enum('role', ['admin', 'employee'])->default('employee');

            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->index(["model_type", "model_id"]);
            $table->text('all_permissions')->nullable()->default(null);
            $table->text('current_permissions')->nullable()->default(null);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
