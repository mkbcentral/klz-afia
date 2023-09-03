<?php

use App\Models\Rate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateIdInDemandeSpecialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_speciales', function (Blueprint $table) {
            $table->foreignIdFor(Rate::class)->after('is_inteneted')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_speciales', function (Blueprint $table) {
            $table->dropIndex('rate_id');
        });
    }
}
