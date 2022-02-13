<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('logo')->after('name')->nullable();
            $table->string('photo')->after('logo')->nullable();
            $table->string('cname')->after('photo')->nullable();
            $table->string('role')->after('cname')->nullable();
            $table->string('department')->after('role')->nullable();
            $table->string('bar_code')->after('department')->nullable();
            $table->string('bcolor')->after('bar_code')->nullable();
            $table->string('pcolor')->after('bcolor')->nullable();
            $table->string('lcolor')->after('pcolor')->nullable();
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
            //
        });
    }
}
