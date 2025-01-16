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
        Schema::create('tbm_estado_tareas', function (Blueprint $table) {
            $table->id('id_estado_tareas'); 
            $table->string('descripcion'); 
            $table->char('estado', 1)->default('A'); 
            $table->ipAddress('ip')->default('127.0.0.1'); 
            $table->dateTime('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
             DB::table('tbm_estado_tareas')->insert([
                ['descripcion' => 'Activo', 'estado' => 'A', 'ip' => '127.0.0.1'],
                ['descripcion' => 'Pendiente', 'estado' => 'A', 'ip' => '127.0.0.1'],
                ['descripcion' => 'Finalizado', 'estado' => 'A', 'ip' => '127.0.0.1'],
                ['descripcion' => 'Eliminado', 'estado' => 'A', 'ip' => '127.0.0.1'],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_tareas');
    }
};
