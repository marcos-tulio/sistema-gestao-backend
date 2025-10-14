<?php

use App\Migrations\MigrationAbstract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationAbstract {

    public function up(): void {
        Schema::create('pricing_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procedure_id')->constrained()->onDelete('cascade');
            $table->boolean('isCurrent')->default(false);
            $table->decimal('price', 11, 4)->default(0);     // 9.999.999,9999
            $table->decimal('commission', 8, 4)->default(0); // 9.999,9999
            $table->decimal('taxes', 8, 4)->default(0);
            $table->decimal('cardTax', 8, 4)->default(0);

            $table->decimal('variableExpenses', 13, 6)->default(0);   // 9.999.999,999999
            $table->decimal('fixedExpenses', 13, 6)->default(0);      // 9.999.999,999999
            $table->decimal('totalExpenses', 13, 6)->default(0);      // 9.999.999,999999
            $table->decimal('directLaborExpenses', 13, 6)->default(0);
            $table->decimal('contributionMargin', 13, 6)->default(0); // 9.999.999,999999
            $table->decimal('profitability', 13, 6)->default(0);      // 9.999.999,999999
            $table->decimal('profitabilityPercentual', 10, 4)->default(0); // 999.999,9999

            $table->boolean('includesDirectLabor')->default(false);
            $table->boolean('includesFixedExpenses')->default(false);
            $table->boolean('includesFixedExpensesPercentual')->default(false);

            $table->decimal('timeSpentInMinutes', 9, 2)->default(0); // 9.999.999,99

            $table->timestamps();
        });

        DB::statement('CREATE UNIQUE INDEX unique_current_pricing_procedures ON pricing_procedures(procedure_id) WHERE "isCurrent" = true;');
    }

    public function down(): void {
        Schema::dropIfExists('pricing_procedures');
    }
};
