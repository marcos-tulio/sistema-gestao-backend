<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->boolean('isIncome');
            $table->boolean('isDeletable')->default(false);
        });
    }

    public function down(): void {
        Schema::dropIfExists('financials');
    }
};
