<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id('buildingID'); 
            $table->string('name'); 
            $table->string('identifier'); 
            $table->timestamps();
        });

        DB::table('buildings')->insert([
            ['name' => 'Edificio A', 'identifier' => 'A', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio B', 'identifier' => 'B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio C', 'identifier' => 'C', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio E', 'identifier' => 'E', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio F', 'identifier' => 'F', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio G', 'identifier' => 'G', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio H', 'identifier' => 'H', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio I', 'identifier' => 'I', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio J', 'identifier' => 'J', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio K', 'identifier' => 'K', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio R', 'identifier' => 'R', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio N', 'identifier' => 'N', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio M', 'identifier' => 'M', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio T', 'identifier' => 'T', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio X', 'identifier' => 'X', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edificio Z', 'identifier' => 'Z', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('buildings');
    }
};
