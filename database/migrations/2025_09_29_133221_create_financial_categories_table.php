<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('financial_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_type_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->unsignedInteger('order')->nullable();
            $table->boolean('isDeletable')->default(true);
        });
    }

    public function down(): void {
        Schema::dropIfExists('financial_categories');
    }
};
