<?php

use App\Models\DemandeConsultation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSigneDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signe_demandes', function (Blueprint $table) {
            $table->id();
            $table->string('temperature')->nullable();
            $table->string('poids')->nullable();
            $table->string('tension')->nullable();
            $table->string('taille')->nullable();
            $table->foreignIdFor(DemandeConsultation::class)->constrained();
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
        Schema::dropIfExists('signe_demandes');
    }
}
