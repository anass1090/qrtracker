<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('qr_links', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('target_url');
            $table->unsignedBigInteger('total_scans')->default(0);
            $table->timestamp('last_scanned_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('qr_links');
    }
};
