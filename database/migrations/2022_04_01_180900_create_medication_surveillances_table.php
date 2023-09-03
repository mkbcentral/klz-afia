<?php

use App\Models\DemandeConsultation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationSurveillancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medication_surveillances', function (Blueprint $table) {
            $table->id();
            $table->integer('qty')->default(0);
            $table->string('time_add')->default(0);
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(DemandeConsultation::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
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
        Schema::dropIfExists('medication_surveillances');
    }
}
