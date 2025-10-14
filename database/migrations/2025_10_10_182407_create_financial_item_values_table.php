<?php

use App\Migrations\MigrationAbstract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationAbstract {

    public function up(): void {
        Schema::create('financial_item_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_item_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->decimal('value', 12, 2)->nullable(); // 9.999.999.999.99

            $table->unique(['financial_item_id', 'year', 'month']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('financial_item_values');
    }
};
