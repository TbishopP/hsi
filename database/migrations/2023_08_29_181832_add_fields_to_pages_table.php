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
        Schema::table('pages', function (Blueprint $table) {
            $table->string('featured_image')->nullable()->after('blocks');
            $table->string('thumbnail_image')->nullable()->after('featured_image');
            $table->string('short_description')->nullable()->after('thumbnail_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('featured_image');
            $table->dropColumn('thumbnail_image');
            $table->dropColumn('short_description');
        });
    }
};
