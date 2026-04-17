<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::create('periodos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('gestion_id')->constrained('gestions')->cascadeOnDelete();
        $table->string('nombre');
        $table->timestamps();

        $table->unique(['gestion_id', 'nombre']);
    });
}

    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};
