<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSymptomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vaers_id')->nullable()->default(null);
            $table->string('symptom1')->nullable()->default(null);
            $table->float('symptomversion1')->nullable()->default(null);
            $table->string('symptom2')->nullable()->default(null);
            $table->float('symptomversion2')->nullable()->default(null);
            $table->string('symptom3')->nullable()->default(null);
            $table->float('symptomversion3')->nullable()->default(null);
            $table->string('symptom4')->nullable()->default(null);
            $table->float('symptomversion4')->nullable()->default(null);
            $table->string('symptom5')->nullable()->default(null);
            $table->float('symptomversion5')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('symptoms');
    }
}
