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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'google2fa_enable')) {
                $table->integer('google2fa_enable')->default(0)->after('commission_amount');
            }
            if (!Schema::hasColumn('users', 'google2fa_secret')) {
                $table->string('google2fa_secret')->nullable()->after('google2fa_enable');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
