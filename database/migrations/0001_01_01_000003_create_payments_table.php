<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hoa_don_id');
            $table->unsignedBigInteger('kt_id');
            $table->unsignedBigInteger('so_tien');
            $table->string('pt_tt', 30)->default('chuyen_khoan');
            $table->string('trang_thai', 20)->default('cho_duyet');
            $table->string('evi')->nullable();
            $table->text('ghichu')->nullable();
            $table->timestamp('pay_at')->nullable();
            $table->timestamps();

            $table->index(['kt_id','hoa_don_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
