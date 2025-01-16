<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbm_materia', function (Blueprint $table) {
            $table->id('id_materia'); 
            $table->string('descripcion'); 
            $table->char('estado', 1)->default('A'); 
            $table->ipAddress('ip')->default('127.0.0.1'); 
            $table->dateTime('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::table('tbm_materia')->insert([
            ['descripcion' => 'Matemáticas', 'estado' => 'A', 'ip' => '127.0.0.1', 'fecha_creacion' => now()],
            ['descripcion' => 'Ciencias', 'estado' => 'A', 'ip' => '127.0.0.1', 'fecha_creacion' => now()],
            ['descripcion' => 'Historia', 'estado' => 'A', 'ip' => '127.0.0.1', 'fecha_creacion' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbm_materia');
    }
};
