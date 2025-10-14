<?php

use App\Migrations\MigrationAbstract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationAbstract {

    public function up(): void {
        Schema::create('pricing_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->boolean('isCurrent')->default(false);
            $table->decimal('price', 11, 4)->default(0);     // 9.999.999,9999
            $table->decimal('commission', 8, 4)->default(0); // 9.999,9999
            $table->decimal('taxes', 8, 4)->default(0);
            $table->decimal('cardTax', 8, 4)->default(0);

            $table->decimal('variableExpenses', 13, 6)->default(0);   // 9.999.999,999999
            $table->decimal('fixedExpenses', 13, 6)->default(0);      // 9.999.999,999999
            $table->decimal('totalExpenses', 13, 6)->default(0);      // 9.999.999,999999
            $table->decimal('contributionMargin', 13, 6)->default(0); // 9.999.999,999999
            $table->decimal('profitability', 13, 6)->default(0);      // 9.999.999,999999
            $table->decimal('profitabilityPercentual', 10, 4)->default(0); // 999.999,9999

            $table->boolean('includesFixedExpenses')->default(false);
            $table->boolean('includesFixedExpensesPercentual')->default(false);

            $table->timestamps();
        });

        DB::statement('CREATE UNIQUE INDEX unique_current_pricing_products ON pricing_products(product_id) WHERE "isCurrent" = true;');
    }

    public function down(): void {
        Schema::dropIfExists('pricing_products');
    }
};
