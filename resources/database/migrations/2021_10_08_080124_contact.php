<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contact extends Migration
{
    public function up(): void
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 64);
            $table->string('company', 64)->nullable();
            $table->string('email', 255);
            $table->string('reason', 255);
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('contact_blocked_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact');
        Schema::dropIfExists('contact_blocked_list');
    }
}
