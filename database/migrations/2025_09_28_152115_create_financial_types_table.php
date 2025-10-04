<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('financial_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('title');
            $table->boolean('isIncome');
            $table->boolean('isDeletable')->default(true);
        });
    }

    public function down(): void {
        Schema::dropIfExists('financial_types');
    }
};
