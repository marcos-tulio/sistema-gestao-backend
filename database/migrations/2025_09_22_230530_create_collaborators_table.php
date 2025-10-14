<?php

use App\Migrations\MigrationAbstract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationAbstract {

    public function up(): void {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->after('name');
            $table->string('profession')->nullable();
            $table->char('type', 1)->default('a'); // 's', 'a' ou 'p'
            $table->boolean('includesDirectLabor')->default(false);
            $table->integer('minutesWorked')->nullable();
            $table->decimal('daysWorked', 6, 2)->nullable();         // 9.999,99
            $table->decimal('totalMinutesWorked', 9, 2)->nullable(); // 9.999.999,99

            $table->decimal('paymentAmount', 9, 2);
            $table->decimal('payment13', 9, 2)->default(0);
            $table->decimal('transportVoucher', 9, 2)->default(0);
            $table->decimal('foodVoucher', 9, 2)->default(0);
            $table->decimal('healthInsurance', 9, 2)->default(0);
            $table->decimal('laborCosts', 9, 2)->default(0);
            $table->decimal('others', 9, 2)->default(0);     // 9.999.999,99
            $table->decimal('totalCost', 10, 2)->default(0); // 99.999.999,99

            $table->decimal('costDirectLaborPerMinute', 15, 8)->nullable(); // 9.999.999,99999999

            $table->index('slug');
        });
    }

    public function down(): void {
        Schema::dropIfExists('collaborators');
    }
};
