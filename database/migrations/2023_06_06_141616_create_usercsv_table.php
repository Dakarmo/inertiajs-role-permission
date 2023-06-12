<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usercsvs', function (Blueprint $table) {
            $table->id();
            $table->string('superviseur')->nullable();
            $table->string('login');
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->string('matricule')->nullable();
            $table->string('genre')->nullable();
            $table->string('campagne')->nullable();
            $table->string('chef_plateau')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('pays')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('usercsv');
    }
};
