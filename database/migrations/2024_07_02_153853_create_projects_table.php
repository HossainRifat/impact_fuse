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
        Schema::create('projects', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->comment('id from users table')->nullable();
            $table->unsignedBigInteger('updated_by_id')->comment('id from users table')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->text('tool_used')->nullable();
            $table->text('feature')->nullable();
            $table->longText('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('link')->nullable();
            $table->tinyInteger('is_featured')->default(0)->comment('0=No, 1=Yes');
            $table->tinyInteger('is_show_on_home')->default(0)->comment('0=No, 1=Yes');
            $table->tinyInteger('status')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
