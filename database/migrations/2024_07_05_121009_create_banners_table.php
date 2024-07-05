<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    final public function up(): void
    {
        Schema::create('banners', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->comment('id from users table')->nullable();
            $table->unsignedBigInteger('updated_by_id')->comment('id from users table')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('video_url')->nullable();
            $table->tinyInteger('location')->nullable();
            $table->integer('sort_order')->nullable();
            $table->string('type')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
