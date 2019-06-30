<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->string('profile_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('description');
        });
    }
}
