<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockOrderFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('min_stock')->default(0)->after('quantity');
            $table->integer('max_stock')->default(0)->after('min_stock');
            $table->integer('min_order')->default(0)->after('max_stock');
            $table->integer('max_order')->default(0)->after('min_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('min_stock');
            $table->dropColumn('max_stock');
            $table->dropColumn('min_order');
            $table->dropColumn('max_order');
        });
    }
} 