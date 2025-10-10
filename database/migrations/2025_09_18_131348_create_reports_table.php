<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->string('report_type', 50)->nullable();
        $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('generated_at')->useCurrent();
        $table->string('file_url')->nullable();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
