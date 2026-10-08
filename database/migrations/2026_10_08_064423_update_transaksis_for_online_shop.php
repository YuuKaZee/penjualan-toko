<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->enum('type', ['offline', 'online'])->default('offline')->after('kode_transaksi');
            $table->string('customer_name')->nullable()->after('kasir_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->text('customer_address')->nullable()->after('customer_phone');
            $table->text('customer_note')->nullable()->after('customer_address');
            $table->enum('order_status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])
                  ->nullable()->after('customer_note');
        });

        // kasir_id jadi nullable untuk order online
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('kasir_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['type', 'customer_name', 'customer_phone', 'customer_address', 'customer_note', 'order_status']);
        });
    }
};