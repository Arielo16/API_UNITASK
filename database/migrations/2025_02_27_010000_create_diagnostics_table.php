<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id('diagnosticID'); 
            $table->unsignedBigInteger('reportID');
            $table->unsignedBigInteger('materialID')->nullable(); // Agregar materialID como columna nullable
            $table->text('description');
            $table->longText('images')->nullable(); // Permitir valores nulos
            $table->enum('status', ['Enviado', 'Para Reparar', 'En Proceso', 'Terminado']);
            $table->timestamps();

            $table->foreign('reportID')->references('reportID')->on('reports')->onDelete('cascade');
            $table->foreign('materialID')->references('materialID')->on('materials')->onDelete('set null'); // Agregar la relación con materials
        });

        DB::table('diagnostics')->insert([
            [
                'reportID' => 1,
                'materialID' => 1,
                'description' => 'Diagnóstico de silla rota en la habitación 101',
                'images' => '',
                'status' => 'Enviado',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'reportID' => 2,
                'materialID' => 2,
                'description' => 'Diagnóstico de reparación de ventana en la habitación 202',
                'images' => '',
                'status' => 'Para Reparar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'reportID' => 3,
                'materialID' => 3,
                'description' => 'Diagnóstico de problema eléctrico en la habitación 303',
                'images' => '',
                'status' => 'En Proceso',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'reportID' => 4,
                'materialID' => 4,
                'description' => 'Diagnóstico de ventana rota en la habitación 404',
                'images' => '',
                'status' => 'Terminado',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'reportID' => 5,
                'materialID' => 5,
                'description' => 'Diagnóstico de problema de plomería en la habitación 505',
                'images' => '',
                'status' => 'Enviado',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostics');
    }
};
