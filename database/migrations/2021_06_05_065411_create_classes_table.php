<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('idFil', 10)->nullable()->index('fk1_fil');
            $table->integer('niv')->nullable()->index('fk2_niv');
            $table->string('titreCourt', 15)->nullable();
            $table->string('titre')->nullable();
            $table->string('anneeUniversitaire', 50)->nullable();
            $table->integer('nbrEtudiant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
