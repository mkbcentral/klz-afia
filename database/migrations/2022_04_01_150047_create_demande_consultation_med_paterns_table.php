<?php

use App\Models\DemandeConsultation;
use App\Models\MedPatern;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeConsultationMedPaternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_consultation_med_patern', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DemandeConsultation::class)->constrained();
            $table->foreignIdFor(MedPatern::class)->constrained();
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
        Schema::dropIfExists('demande_consultation_med_paterns');
    }
}
