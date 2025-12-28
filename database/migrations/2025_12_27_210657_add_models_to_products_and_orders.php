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
        Schema::table('products', function (Blueprint $table) {
            $table->json('available_models')->nullable()->after('secondary_images');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('selected_model')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('available_models');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('selected_model');
        });
    }
};
