<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('qr_scan_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_link_id')->constrained()->cascadeOnDelete();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 1024)->nullable();
            $table->string('referer', 1024)->nullable();
            $table->string('device_hint', 64)->nullable(); // optional quick UA parse
            $table->timestamps();
            $table->index(['qr_link_id', 'created_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('qr_scan_events');
    }
};
