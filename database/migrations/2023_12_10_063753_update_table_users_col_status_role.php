<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add a new column
            $table->string('status')->change()->default('active')->nullable();
            $table->string('role')->change()->default('user')->nullable();
        });
    }

    public function down()
    {
        /* Schema::table('users', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            $table->dropColumn('status');
            $table->dropColumn('role');
        }); */
    }
};
