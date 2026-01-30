<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reds', function (Blueprint $table) {
            $table->id();
            $table->string('red', 50)->unique();
            $table->string('abreviatura', 20)->unique();
            $table->string('descripcion')->nullable()->default(null);
            $table->string('observacion')->nullable()->default(null);
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('medio_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->unique();
            $table->string('abreviatura', 20)->unique();
            $table->string('descripcion')->nullable()->default(null);
            $table->string('observacion')->nullable()->default(null);
            
            $table->timestamps();
            $table->softDeletes();
        });
    
        Schema::create('medios', function (Blueprint $table) {
            $table->id();
            $table->string('inventario', 5)->unique();
            $table->string('inventario_viejo', 13)->nullable()->default(null);
            $table->string('serie', 50)->nullable()->default(null);
            $table->string('ip', 15)->nullable()->default(null);
            $table->foreignId('red_id')->constrained();
            $table->foreignId('medio_tipo_id')->constrained();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medios');
        Schema::dropIfExists('reds');
        Schema::dropIfExists('medio_tipos');
    }
};
