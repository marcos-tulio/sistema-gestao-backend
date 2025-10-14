<?php

use App\Migrations\MigrationAbstract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationAbstract {

    public function up(): void {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->after('name');
            $table->unsignedInteger('quantity');
            $table->string('unit');
            $table->decimal('purchasePrice', 11, 4); // 9.999.999,9999
            $table->decimal('unitCost', 13, 6);      // 9.999.999,999999

            $table->index('slug');
        });
    }

    public function down(): void {
        Schema::dropIfExists('materials');
    }
};
