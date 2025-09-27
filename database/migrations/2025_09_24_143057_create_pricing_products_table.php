<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('pricing_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->boolean('isCurrent')->default(false);
            $table->decimal('price', 11, 4)->default(0);     // 9.999.999,9999
            $table->decimal('commission', 8, 4)->default(0); // 9.999,9999
            $table->decimal('taxes', 8, 4)->default(0);
            $table->decimal('cardTax', 8, 4)->default(0);

            $table->decimal('variableExpenses', 13, 8)->default(0);   // 9.999.999,999999
            $table->decimal('fixedExpenses', 13, 8)->default(0);      // 9.999.999,999999
            $table->decimal('totalExpenses', 13, 8)->default(0);      // 9.999.999,999999
            $table->decimal('contributionMargin', 13, 8)->default(0); // 9.999.999,999999
            $table->decimal('profitability', 13, 8)->default(0);      // 9.999.999,999999

            $table->boolean('includesFixedExpenses')->default(false);
            $table->boolean('includesFixedExpensesPercentual')->default(false);

            $table->timestamps();
        });

        DB::statement('CREATE UNIQUE INDEX unique_current_pricing ON pricing_products(product_id) WHERE "isCurrent" = true;');
    }

    public function down(): void {
        Schema::dropIfExists('pricing_products');
    }
};
