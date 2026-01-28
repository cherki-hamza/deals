<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('amazon_affiliate_url');
            $table->string('amazon_asin')->nullable()->comment('For future Amazon PA API integration');
            $table->string('price_text')->nullable()->comment('Display price like "$99.99"');
            $table->string('original_price_text')->nullable()->comment('Original price for strikethrough');
            $table->string('discount_text')->nullable()->comment('e.g., "20% OFF"');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->json('images')->nullable()->comment('Array of image paths');
            $table->json('highlights')->nullable()->comment('Array of product highlights/features');
            $table->boolean('featured')->default(false);
            $table->boolean('deal_of_the_day')->default(false);
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('featured');
            $table->index('deal_of_the_day');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
