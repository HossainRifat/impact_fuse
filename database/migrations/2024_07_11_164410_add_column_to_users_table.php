<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('email');
            $table->date('start_date')->nullable()->after('date_of_birth');
            $table->date('end_date')->nullable()->after('start_date');
            $table->integer('sort_order')->nullable()->after('end_date')->comment('higher number will be displayed first');
            $table->string('department')->nullable()->after('sort_order');
            $table->text('responsibility')->nullable()->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('sort_order');
            $table->dropColumn('responsibility');
            $table->dropColumn('department');
        });
    }
};
