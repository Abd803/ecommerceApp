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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_firstname');
            $table->string('customer_phone');
            $table->string('customer_wilaya');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', [
                'new', 'confirmed', 'preparing', 
                'shipped', 'delivered', 'cancelled', 'fake'
            ])->default('new');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->text('admin_notes')->nullable();
            $table->boolean('is_suspected_fraud')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
