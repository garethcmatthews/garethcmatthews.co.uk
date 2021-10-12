<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Technology extends Migration
{
    public function up(): void
    {
        Schema::create('technology', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 64);
            $table->string('tag', 32);
            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('technology_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 100);
            $table->text('url');
            $table->boolean('primary');
            $table->boolean('active');
            $table->integer('orderby');
            $table->unsignedInteger('technology_id');
            $table->timestamps();
        });

        Schema::table('technology_items', function (Blueprint $table) {
            $table->foreign('technology_id')->references('id')->on('technology')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('technology');
        Schema::dropIfExists('technology_items');
    }
}
