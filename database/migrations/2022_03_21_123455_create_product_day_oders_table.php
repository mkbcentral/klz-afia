<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDayOdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_day_oders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_day_con_id')
                ->constrained('product_day_cons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type');
            $table->integer('qty')->default(0);
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
        Schema::dropIfExists('product_day_oders');
    }
}
