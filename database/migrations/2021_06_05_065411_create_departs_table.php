<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departs', function (Blueprint $table) {
            $table->string('NODEP', 2)->primary();
            $table->string('LDEPL', 30)->nullable();
            $table->string('LDEPA', 30)->nullable();
            $table->string('CDEPA', 30)->nullable();
            $table->string('CDEPL', 30)->nullable();
            $table->string('TDEP', 12)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departs');
    }
}
