<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nomsalle', 20);
            $table->string('cycle', 10)->nullable()->index('fk1_cycle');
            $table->string('Sitefr', 50)->nullable();
            $table->string('SiteAr', 50)->nullable();
            $table->integer('CapSal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salles');
    }
}
