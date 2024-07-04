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
        Schema::create('pages', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->comment('id from users table')->nullable();
            $table->unsignedBigInteger('updated_by_id')->comment('id from users table')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('is_show_on_header')->default(0);
            $table->tinyInteger('is_show_on_footer')->default(0);
            $table->integer('display_order')->nullable();
            $table->bigInteger('impression')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
