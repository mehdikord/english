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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->boolean('is_pay')->default(0);
            $table->string('paid_at')->nullable();
            $table->string('ref_id')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('card_number')->nullable();
            $table->string('gateway')->nullable();
            $table->string('gateway_code')->nullable();
            $table->string('method')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('admin_id')->references('id')->on('admins')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
