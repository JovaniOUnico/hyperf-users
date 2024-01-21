<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class Update4UserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users') || Schema::hasTable('user')) {
            Schema::dropIfExists('user');
            Schema::dropIfExists('users');

            Schema::table('user', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 60);
                $table->string('email', 60)->unique();
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
}
