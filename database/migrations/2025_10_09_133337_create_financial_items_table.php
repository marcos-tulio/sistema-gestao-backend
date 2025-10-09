<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('financial_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('title');
            $table->boolean('isDeletable')->default(true);
            $table->boolean('isEditable')->default(true);

            $table->unique(['financial_category_id', 'name']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('financial_items');
    }
};
