<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('project_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('type'); // image|video|file
            $table->string('title')->nullable();
            $table->string('path')->nullable(); // storage path (public disk)
            $table->string('external_url')->nullable(); // youtube/vimeo/etc
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->string('provider')->default('youtube'); // youtube|vimeo|file
            $table->string('provider_id')->nullable(); // e.g. YouTube ID
            $table->string('thumbnail_url')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->string('sku')->nullable()->index();
            $table->unsignedInteger('price_cents')->default(0);
            $table->string('currency', 3)->default('INR');
            $table->integer('inventory_qty')->default(0);
            $table->boolean('is_published')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('product_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('type'); // image|video|file
            $table->string('title')->nullable();
            $table->string('path')->nullable();
            $table->string('external_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('contact')->index(); // contact|quote
            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('company')->nullable();
            $table->longText('message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending')->index(); // pending|confirmed|cancelled|fulfilled
            $table->string('customer_name');
            $table->string('customer_email')->nullable()->index();
            $table->string('customer_phone')->nullable()->index();
            $table->unsignedInteger('subtotal_cents')->default(0);
            $table->string('currency', 3)->default('INR');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('title');
            $table->string('sku')->nullable();
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedInteger('unit_price_cents')->default(0);
            $table->unsignedInteger('line_total_cents')->default(0);
            $table->timestamps();
        });

        Schema::create('kb_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body');
            $table->string('tags')->nullable(); // comma-separated tags
            $table->boolean('is_published')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kb_articles');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('product_media');
        Schema::dropIfExists('products');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('project_media');
        Schema::dropIfExists('projects');
    }
};

