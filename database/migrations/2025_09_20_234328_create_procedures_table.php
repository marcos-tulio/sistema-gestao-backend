<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do procedimento
            $table->string('slug')->after('name');
            $table->decimal('materialsCost', 15, 8)->default(0); // 9.999.999,99999999

            $table->index('slug');
        });

        // Tabela pivot para relacionar procedimentos e materiais
        Schema::create('material_procedure', function (Blueprint $table) {
            $table->foreignId('procedure_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');

            $table->integer('quantityUsed');     // Quantidade usada no procedimento
            $table->decimal('totalCost', 15, 8); // 9.999.999,99999999

            $table->primary(['procedure_id', 'material_id']);
        });
    }


    public function down(): void {
        Schema::dropIfExists('material_procedure');
        Schema::dropIfExists('procedures');
    }
};
