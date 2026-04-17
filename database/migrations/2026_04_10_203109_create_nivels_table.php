<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('nivel_id')
              ->nullable()
              ->constrained('nivels')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['nivel_id']);
        $table->dropColumn('nivel_id');
    });
}
};
