<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTables extends Migration
{
    public function up()
    {
        // Coleções
        Schema::create('product_collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('store_id');
            $table->timestamps();
        });

        // Marcas
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('store_id');
            $table->timestamps();
        });

        // Selos e Tags
        Schema::create('product_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('tag'); // tag ou selo
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('store_id');
            $table->timestamps();
        });

        // Filtros
        Schema::create('product_filters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type'); // select, checkbox, radio, color, etc
            $table->boolean('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('store_id');
            $table->timestamps();
        });

        // Valores dos Filtros
        Schema::create('product_filter_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filter_id')->constrained('product_filters')->onDelete('cascade');
            $table->string('value');
            $table->string('slug')->unique();
            $table->string('color')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Tabelas Pivot
        Schema::create('product_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('collection_id')->constrained('product_collections')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('product_tags')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_filter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('filter_id')->constrained('product_filters')->onDelete('cascade');
            $table->foreignId('filter_value_id')->constrained('product_filter_values')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_filter');
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('product_collection');
        Schema::dropIfExists('product_filter_values');
        Schema::dropIfExists('product_filters');
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('product_brands');
        Schema::dropIfExists('product_collections');
    }
} 