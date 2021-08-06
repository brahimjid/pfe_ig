<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyclenivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cyclenivs', function (Blueprint $table) {
            $table->string('idCycle', 10);
            $table->integer('idNiv')->index('fk2_niv');
            $table->string('nom', 30)->nullable();
            $table->primary(['idCycle', 'idNiv']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cyclenivs');
    }
}
