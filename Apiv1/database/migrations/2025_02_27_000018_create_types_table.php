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
        Schema::create('types', function (Blueprint $table) {
            $table->id('typeID'); 
            $table->string('name');
            $table->timestamps(); 
        });

        DB::table('types')->insert([
            ['name' => 'Aula', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laboratorio', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oficina', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Auditorio', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Biblioteca', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baño', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
};
