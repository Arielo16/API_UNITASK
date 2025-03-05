<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaterialIdToDiagnosticsTable extends Migration
{
    public function up()
    {
        Schema::table('diagnostics', function (Blueprint $table) {
            $table->unsignedBigInteger('materialID')->nullable()->after('status');
            $table->foreign('materialID')->references('materialID')->on('materials')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('diagnostics', function (Blueprint $table) {
            $table->dropForeign(['materialID']);
            $table->dropColumn('materialID');
        });
    }
}
