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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('timing')->comment('0=>Morning, 1=>Noon, 2=>Evening')->nullable();
            $table->integer('sider')->default(0);
            $table->integer('bridal')->default(0);
            $table->text('address')->nullable();
            $table->text('comment')->nullable();
            $table->double('price',8,2)->default(0);
            $table->tinyInteger('status')->comment('0=>Pending, 1=>Completed, 2=>Cancled')->default(0);
            $table->tinyInteger('is_paid')->comment('0=>Unpaid, 1=>Paid')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
