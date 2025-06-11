<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSalesChannelsTables extends Migration
{
    public function up()
    {
        // Tabela de canais de venda
        Schema::create('sales_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabela pivot para relacionar produtos com canais
        Schema::create('product_sales_channel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('sales_channel_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Inserir canais padrão
        DB::table('sales_channels')->insert([
            [
                'name' => 'Minha Loja',
                'slug' => 'minha-loja',
                'icon' => 'ti ti-shopping-bag',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mercado Livre',
                'slug' => 'mercado-livre',
                'icon' => 'ti ti-brand-mercado',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Shopee',
                'slug' => 'shopee',
                'icon' => 'ti ti-brand-shopee',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Google Shopping',
                'slug' => 'google-shopping',
                'icon' => 'ti ti-brand-google',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('product_sales_channel');
        Schema::dropIfExists('sales_channels');
    }
} 