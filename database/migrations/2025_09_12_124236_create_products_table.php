<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('quantity');
            $table->string('unit');
            $table->decimal('purchasePrice', 11, 4); // 9.999.999,9999
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
