<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Links extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 100);
            $table->text('description');
            $table->text('url');
            $table->string('image', 24)->nullable()->default(null);
            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('links_tags', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 32)->unique();
            $table->string('title', 64);
            $table->timestamps();
        });

        Schema::create('links_tag_link', function (Blueprint $table) {
            $table->integer('link_id');
            $table->foreign('link_id')->references('id')->on('links');

            $table->integer('links_tag_id');
            $table->foreign('links_tag_id')->references('id')->on('links_tags');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('links');
        Schema::dropIfExists('links_tags');
        Schema::dropIfExists('links_tag_link');
    }
}
