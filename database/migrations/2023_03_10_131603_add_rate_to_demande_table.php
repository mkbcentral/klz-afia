<?php

use App\Models\Rate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateToDemandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_consultations', function (Blueprint $table) {
            $table->foreignIdFor(Rate::class)->nullable()->after('is_livred')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_consultations', function (Blueprint $table) {
            $table->dropColumn('rate_id');
        });
    }
}
