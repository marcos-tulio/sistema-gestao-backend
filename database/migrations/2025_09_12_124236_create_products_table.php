<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->after('name');
            $table->unsignedInteger('quantity')->default(1);
            $table->string('unit');
            $table->decimal('purchasePrice', 11, 4)->default(0);; // 9.999.999,9999

            $table->index('slug');
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
