<?php

use App\Models\DemandeConsultation;
use App\Models\ExamenLabo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labo_results', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(DemandeConsultation::class)->constrained();
            $table->foreignIdFor(ExamenLabo::class)->constrained();
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
        Schema::dropIfExists('labo_results');
    }
}
