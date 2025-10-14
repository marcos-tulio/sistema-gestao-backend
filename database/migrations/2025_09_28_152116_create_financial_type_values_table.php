<?php

use App\Migrations\MigrationAbstract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationAbstract {

    public function up(): void {
        Schema::create('financial_type_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_type_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->decimal('value', 12, 2)->nullable(); // 9.999.999.999.99

            $table->unique(['financial_type_id', 'year', 'month']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('financial_type_values');
    }
};
