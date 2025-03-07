<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticMaterialTable extends Migration
{
    public function up()
    {
        Schema::create('diagnostic_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagnosticID');
            $table->unsignedBigInteger('materialID');
            $table->timestamps();

            $table->foreign('diagnosticID')->references('diagnosticID')->on('diagnostics')->onDelete('cascade');
            $table->foreign('materialID')->references('materialID')->on('materials')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagnostic_material');
    }
}
