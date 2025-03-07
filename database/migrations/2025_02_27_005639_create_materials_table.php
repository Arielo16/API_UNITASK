<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id('materialID'); // Asegúrate de que esta columna esté correctamente definida
            $table->string('name'); 
            $table->timestamps();
        });

        DB::table('materials')->insert([
            [
                'name' => 'Wooden Planks',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Aluminum Sheets',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Electrical Wires',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Glass Panels',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'PVC Pipes',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
