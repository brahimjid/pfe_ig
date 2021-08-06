<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->integer('Matricule')->default(0)->primary();
            $table->string('Nom', 200)->nullable();
            $table->string('Noma', 200)->nullable();
            $table->string('nodep', 2)->nullable()->index('fk1_departs');
            $table->string('type', 50)->nullable();
            $table->string('Adresse')->nullable();
            $table->dateTime('daten')->nullable();
            $table->string('lieun', 80)->nullable();
            $table->string('Nat', 40)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('Diplome', 100)->nullable();
            $table->integer('TauxHor')->nullable();
            $table->integer('NbHrAPayer')->nullable();
            $table->string('sexe', 15)->nullable();
            $table->string('Banque', 30)->nullable()->index('fk_banque');
            $table->string('NumCompte', 50)->nullable();
            $table->integer('nbcours')->nullable();
            $table->string('grade', 2)->nullable()->index('fk_grades');
            $table->string('Nomf', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professeurs');
    }
}
